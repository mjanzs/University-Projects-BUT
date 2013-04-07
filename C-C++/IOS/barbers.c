/*
 * File:   barbers.c
 * Author: Martin Janys, xjanys00@stud.fit.vutbr.cz
 * 
 * IOS, projekt 2, synchronizace procesu
 *
 * Created on 2011-4-9, 10:09
 */

#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>
#include <errno.h>
#include <time.h>
#include <string.h>

#include <unistd.h>
#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/shm.h>
#include <semaphore.h>
#include <wait.h>

#define ALL_SEM 8
/** makra pro bezpecne zachazeni se semafory */
#define SEM_WAIT(sem) (sem_wait(sem) != 0 ? kill(getppid(), SIGTERM),\
                                            Error(strerror(errno)), exit(1), 1\
                                            : 0)

#define SEM_POST(sem) (sem_post(sem) != 0 ? kill(getppid(), SIGTERM),\
                                            Error(strerror(errno)), exit(1), 1\
                                            : 0)
/**
 * struktura zpracovanych parametru
 */
struct param {
  unsigned long Q; /**< pocet zidli */
  unsigned long GenC; /**< rozsah pro generova¡ni­ za¡kaznika [ms] */
  unsigned long GenB; /**< rozsah pro generova¡ni­ doby obsluhy [ms] */
  unsigned long N; /**< pocet zakazniku */
  char* F; /**< vystupni soubor */
};
/**
 * Stuktura ve sdilené pamìti
 */
typedef struct TShmData {
  int counter; /**< pocitadlo zprav */
  int customers; /**< pocet generovanych zakazniku */
  int chairs; /**< pocet zidli v cekarne */
  int refused; /**< pomocna promenna odmitnutych */
  int waiting; /**< pocet cekajicich */
  sem_t Barber_finished; /**< zprava ze holic dostrihal */
  sem_t Barber_ready; /**< zprava o pripraceni holice */
  sem_t Customer_leave; /**< dava zpravu ze zakaznik odesel */ //nepovinna synch
  sem_t Customer_ready; /**< zprava o pripraveni zakaznika */
  sem_t Customer_refused; /**< vylouceni pro pocitani odminutych */
  sem_t Customer_wait; /**< zakaznik je v cekarne a ceka */
  sem_t Mutex; /**< vylouceni pro promennou poctu lidi v cekarne */
  sem_t Print; /**< vylouceni pri tisku a inkrementaci counteru*/
} TSHMDATA;

TSHMDATA* g_Data = NULL;
int shmid;

struct param get_param(int argc, char** argv);
void customers(int number, FILE* output);
void barber(unsigned long worktime, FILE* output);
void Error(const char *fmt, ...);
void mem_init(struct param params);
void cleanup(int count);
/**
 * Dealokace sdilene pameti pri Ctrl-C
 */
void terminate_shm() {
  //dealokace pameti
  shmdt((void *)g_Data);
  shmctl(shmid, IPC_RMID, NULL);
  g_Data = NULL;// printf("konec\n");
}
/**
 *
 * @param argc
 * @param argv
 * @return
 */
int main(int argc, char** argv) {
  
  void (*prev_fn)(int);
 
  prev_fn = signal (SIGINT, terminate_shm); // zachytavani signalu ctrl-C
  if (prev_fn==SIG_IGN) signal (SIGINT ,SIG_IGN);

  prev_fn = signal (SIGKILL, terminate_shm); // zachytavani signalu kill
  if (prev_fn==SIG_IGN) signal (SIGKILL ,SIG_IGN);

  prev_fn = signal (SIGTERM, terminate_shm); // zachytavani signalu term
  if (prev_fn==SIG_IGN) signal (SIGTERM ,SIG_IGN);
  
  signal(SIGCHLD, SIG_IGN);;

  srand(time(NULL)); // inicializace generator nahodnych cisel

  errno = 0;
  int forkerror = 0;
  struct param params; // parametry programu
  pid_t pid, barberspid;
  FILE* output;

  params = get_param(argc, argv); // zpracovani parametru
/* printf(" zidle: %lu\n"
    " cas zakaznici: %lu\n"
    " cas obsluha: %lu\n"
    " pocet zakazniku: %lu\n"
    " out: %s\n", \
    params.Q,\
    params.GenC,\
    params.GenB,\
    params.N,\
    params.F);
*/
  pid_t children[params.N];

// volba a otevreni vstupu
  if (strcmp(params.F, "-") == 0)
    output = stdout;
  else {
    output = fopen(params.F, "w");
    if (output == NULL)
      Error("Vystupni soubor %s se nepodarilo otevrit", params.F);
    //setbuf(output, NULL); // nutne pro korektni vypis do souboru
  }
  setbuf(output, NULL);
  mem_init(params); // alokace a inicializace potrebnych prostredku

  pid = fork(); // vytvoreni procesu holice
  switch(pid) {
    case -1:
      Error("1. volani fork() selhalo");
      cleanup(ALL_SEM);
      exit(1);
      break;
    case 0: /* child */
      barber(params.GenB, output);
      exit(0);
      break;
    default:
      barberspid = pid;
  }

  for(unsigned int i = 0; i < params.N; i++) {
    pid = fork(); // vytvoreni vsech zakazniku v intervalech
    switch(pid) {
      case -1: // chyba -> uklid a konec
        SEM_WAIT(&g_Data->Print); // zamknuti vypisu
	
	terminate_shm();
	
        Error("%d. volani fork() selhalo\n", i+2); //+1 barber +1 od i
        forkerror = 1;
        
        // uklid
        for(unsigned int ii = 0; ii < i; ii++)
          kill(children[ii], SIGTERM);
        
        kill(barberspid, SIGTERM);

        if(output != stdout)
          fclose(output);
        
        //terminate_shm();
         
        exit(1);
        break;
      case 0: /* children */
        SEM_WAIT(&g_Data->Print); // ceka na pristup k tisku, KS - counter
        fprintf(output, "%d: customer %d: created\n", g_Data->counter++, i+1);
        SEM_POST(&g_Data->Print);

        customers(i+1, output);
        exit(0);
        break;
      default:
         children[i] = pid;
    }
    if (params.GenC != 0)
      usleep(rand() % (params.GenC * 1000)); // zakaznici jsou generovani v intervalech
    if (forkerror)
      exit(1);
  }

  for(unsigned int i = 0; i < params.N; i++)
    waitpid(children[i], NULL, 0); //cekani na potomky

  kill(barberspid, SIGTERM); // ukonceni holice
  waitpid(barberspid, NULL, 0);

  cleanup(ALL_SEM); //dealokace zdroju
  if (strcmp(params.F, "-") != 0)
    if(fclose(output) != 0) { // zavreni souboru
      Error(strerror(errno));
      exit(1);
    }

  return (EXIT_SUCCESS);
}
/**
 * Funkce zakaznika
 * @param num cislo zakaznika
 * @param output vystupni stream
 */
void customers(int num, FILE* output) {
//printf("customer\n");
  SEM_WAIT(&g_Data->Mutex); // pristup k cekarne a promennym okolo cekarny

  SEM_WAIT(&g_Data->Print);
  fprintf(output, "%d: customer %d: enters\n", g_Data->counter++, num);
  SEM_POST(&g_Data->Print); // zpristupneni KS

  if (g_Data->waiting < g_Data->chairs) { // dokud jsou volne zidle v cekarne
    g_Data->waiting++; // cekajici v cekarne
    SEM_POST(&g_Data->Mutex);

    SEM_POST(&g_Data->Customer_wait);

    SEM_WAIT(&g_Data->Barber_ready); // ceka dokud ho holic neprijme
    
    SEM_WAIT(&g_Data->Print); // ceka na pristup k tisku
    fprintf(output, "%d: customer %d: ready\n", g_Data->counter++, num);
    SEM_POST(&g_Data->Print); // zpristupneni ostatnim

    SEM_POST(&g_Data->Customer_ready); // zakaznik rika ze ceka

    SEM_WAIT(&g_Data->Barber_finished); // ceka dokud neni ostrihan
    
    SEM_WAIT(&g_Data->Print); // ceka na pristup k tisku
    fprintf(output, "%d: customer %d: served\n", g_Data->counter++, num);
    SEM_POST(&g_Data->Print); // zpristupni tisk
    
    SEM_POST(&g_Data->Customer_leave); // zakaznik odchazi
  }
  else {

    SEM_WAIT(&g_Data->Customer_refused); // ceka na pristup k promenne poctu odmitnutych
    g_Data->refused++;
    SEM_POST(&g_Data->Customer_refused); //zpristupnuje sekci
    
    SEM_WAIT(&g_Data->Print); // ceka na zpristupneni k tisk
    fprintf(output, "%d: customer %d: refused\n", g_Data->counter++, num);
    SEM_POST(&g_Data->Print); // zpristupnuje tisk

    SEM_POST(&g_Data->Mutex);
  }
  if(output != stdout)
    fclose(output);

}
/**
 * Funkce holice
 * @param worktime vrchni rozsah pro generovnani casu (prace holice)
 * @param output vystupni stream
 */
void barber(unsigned long worktime, FILE* output) {
//printf("barber\n");
  for (int i = 0; i < g_Data->customers; i++) {

    SEM_WAIT(&g_Data->Mutex); // pristup k cekarne a promennym okolo cekarny
    SEM_WAIT(&g_Data->Print); // ceka na zpristupneni tisku
    fprintf(output, "%d: barber: checks\n", g_Data->counter++);
    SEM_POST(&g_Data->Print); // zpristupni tisk
    SEM_POST(&g_Data->Mutex);

    SEM_WAIT(&g_Data->Customer_wait);

    SEM_WAIT(&g_Data->Print); // ceka na tisk
    fprintf(output, "%d: barber: ready\n", g_Data->counter++);
    SEM_POST(&g_Data->Print); // zpristupni tisk

    SEM_POST(&g_Data->Barber_ready); // dava zpravu ze je pripraven

    SEM_WAIT(&g_Data->Customer_ready); // ceka az bude mit ready zakaznika

    SEM_WAIT(&g_Data->Mutex);
    g_Data->waiting--; // veme zakaznika z cekarny
    SEM_POST(&g_Data->Mutex);

    if (worktime != 0)
      usleep(rand() % (worktime * 1000) + 1); // simulace prace (nahodne v intervalu)

    SEM_WAIT(&g_Data->Print); //ceka na zpristupneni tisku
    fprintf(output, "%d: barber: finished\n", g_Data->counter++);
    SEM_POST(&g_Data->Print); // zpristupni tisk

    SEM_POST(&g_Data->Barber_finished);

    SEM_WAIT(&g_Data->Customer_leave); // ceka az zakaznik odejde

    SEM_WAIT(&g_Data->Customer_refused); /* sekce je defaultne zpristupnena
      pokud zazaknik odejde neobslouzen holic se o tom dozvi a zvetsi pocet
      zakazniku kteri odesli*/
    i = i + g_Data->refused; // pricte jestli byl nejaky neoslouizen
    g_Data->refused = 0; // a vrati na nulu
    SEM_POST(&g_Data->Customer_refused);
  }
  if(output != stdout)
    fclose(output);
}
/**
 * Allokuje a inicializuje pamet
 * @param params parametry
 */
void mem_init(struct param params) {
  
  int test;

  key_t key = ftok("./barbers", getpid()); // tez mozno IPC_PRIVATE
  shmid = shmget(key , sizeof(TSHMDATA), IPC_CREAT | IPC_EXCL | 0600); // alokace sdilene pameti
  if (shmid == -1) {
    Error(strerror(errno));
    exit(1);
  }
  g_Data = (TSHMDATA *)shmat(shmid, NULL, 0); // mapovani pameti
  if (g_Data == (void*)-1) {
    Error(strerror(errno));
    exit(1);
  }
  g_Data->counter = 1; // citac
  g_Data->chairs = params.Q; // pocet zidli v cekarne
  g_Data->customers = params.N; // pocet vygenerovanych zakazniku
  g_Data->waiting = 0; // pocet aktualne cekajicich
  g_Data->refused = 0; // odmitnuty zakaznik

/* semafor: */
  test = sem_init(&g_Data->Barber_finished, 1, 0); // dokonceni prace holice
  if (test == -1) {			// pri chybe
    cleanup(0);				// vola cleanup s poctem semaforu k uvolneni
    Error(strerror(errno)); // vypis chyby
    exit(1);
  }
  test = sem_init(&g_Data->Barber_ready, 1, 0); // holic je propraven
  if (test == -1) {
    cleanup(1);
    Error(strerror(errno));
    exit(1);
  }
  test = sem_init(&g_Data->Customer_leave, 1, 0); // zakaznik odchazi
  if (test == -1) {
    cleanup(2);
    Error(strerror(errno));
    exit(1);
  }
  test = sem_init(&g_Data->Customer_ready, 1, 0); // zakaznik pripraven
  if (test == -1) {
    cleanup(3);
    Error(strerror(errno));
    exit(1);
  }
  test = sem_init(&g_Data->Customer_refused, 1, 1); // zakaznik neobslouzen
  if (test == -1) {
    cleanup(4);
    Error(strerror(errno));
    exit(1);
  }
  test = sem_init(&g_Data->Customer_wait, 1, 0); // zakaznik je v cekarne
  if (test == -1) {
    cleanup(5);
    Error(strerror(errno));
    exit(1);
  }
  test = sem_init(&g_Data->Mutex, 1, 1); // vylouceni pristupu k poctu v cekarne
  if (test == -1) {
    cleanup(6);
    Error(strerror(errno));
    exit(1);
  }
  test = sem_init(&g_Data->Print, 1, 1); // je mozne tisknout
  if (test == -1) {
    cleanup(7);
    Error(strerror(errno));
    exit(1);
  }
  //sem_init(&g_Data->Customer_all, 1, params.N);
}
/**
 * Dealokace zdroju
 * @param count pocet semaforu ktere byly alokovany a museji se dealokovat
 */
void cleanup (int count) {
 //dealokace semaforu podle poctu naalokovanych
  switch (count) {
    case 0:
      break;
    case 8:
      sem_destroy(&g_Data->Print);
    case 7:
      sem_destroy(&g_Data->Mutex);
    case 6:
      sem_destroy(&g_Data->Customer_wait);
    case 5:
      sem_destroy(&g_Data->Customer_refused);
    case 4:
      sem_destroy(&g_Data->Customer_ready);
    case 3:
      sem_destroy(&g_Data->Customer_leave);
    case 2:
      sem_destroy(&g_Data->Barber_ready);
    case 1:
      sem_destroy(&g_Data->Barber_finished);
  }
  //sem_destroy(&g_Data->Customer_all);
//dealokace pameti
  terminate_shm();
}
/**
 * Zpracuje parametry
 * @param argc
 * @param argv
 * @return struktura s parametry
 */
struct param get_param(int argc, char** argv) {

  struct param result;
  char* endptr;

  if (argc != 6) {
    Error("Nespravny pocet parametru");
    exit(1);
  }
  else {
    //overeni zda se jedna o kladna cisla
    if (argv[1][0] == '-' || argv[2][0] == '-' || argv[3][0] == '-' || argv[4][0] == '-') {
      Error("Cisla nesmeji byt zaporna");
      exit(1);
    }
    result.Q = strtoul(argv[1], &endptr, 10);
    if (errno == ERANGE) {
      Error("Doslo k preteceni cisla %s (cislo je mimo rozsah)", argv[1]);
      exit(1);
    }
    if (*endptr != '\0') {
      Error("Parametr %d neni cislo", 1);
      exit(1);
    }
    /*if (result.Q == 0) {
      Error("Parametr 0 zidli neni podporovan");
      exit(1);
    }*/
   
    result.GenC = strtoul(argv[2], &endptr, 10);
    if (errno == ERANGE) {
      Error("Doslo k preteceni cisla %s (cislo je mimo rozsah)", argv[2]);
      exit(1);
    }
    if (*endptr != '\0') {
      Error("Parametr %d neni cislo", 2);
      exit(1);
    }

    result.GenB = strtoul(argv[3], &endptr, 10);
    if (errno == ERANGE) {
      Error("Doslo k preteceni cisla %s (cislo je mimo rozsah)", argv[3]);
      exit(1);
    }
    if (*endptr != '\0') {
      Error("Parametr %d neni cislo", 3);
      exit(1);
    }

    result.N = strtoul(argv[4], &endptr, 10);
    if (errno == ERANGE) {
      Error("Doslo k preteceni cisla %s (cislo je mimo rozsah)", argv[4]);
      exit(1);
    }
    if (*endptr != '\0') {
      Error("Parametr %d neni cislo", 4);
      exit(1);
    }
    /*if (result.N == 0) {
      Error("Parametr 0 zakazniku neni podporovan");
      exit(1);
    }*/

    result.F = argv[5];
  }

return result;
}
/**
 * Tisk chyboveho hlaseni
 * @param fmt formatovaci retezec
 * @param ... promenny pocet parametru
 */
void Error(const char *fmt, ...)
{
  va_list args;
  va_start(args, fmt);

  fprintf(stderr,"Error: ");

  vfprintf(stderr, fmt, args);
  fprintf(stderr,"\n");
  va_end(args);
}
