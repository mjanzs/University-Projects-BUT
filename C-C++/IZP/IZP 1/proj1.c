/*
 * Soubor:  proj1.c
 * Datum:   2010/10/30
 * Autor:   Martin Jany�, xjanys00@fit.vutbr.cz
 * Projekt: Jednoduch� komprese textu, projekt �. 1 pro p�edm�t IZP
 * Popis:   Program umi komprimovat nebo dekomprimovat text podle
 *          parametr� zadan�ch z p��kazov�ho ��dku p�i spou�t�n�.
 */
#include <stdio.h>
#include <stdlib.h>
// kv�li funkci strcmp
#include <string.h>
// testov�n� znak� - isalpha, isdigit, atd.
#include <ctype.h>

int dekomprese(int N);
int komprese(int N);

/** K�dy chyb programu */
enum tecodes
{
  EOK = 0,     /**< Bez chyby */
  ECLWRONG,    /**< Chybn� p��kazov� ��dek. */
// sem m��ete p�idat vlastn� chybov� k�dy
  EUNKNOWN,    /**< Nezn�m� chyba */
};

/** Stavov� k�dy programu */
enum tstates
{
  CHELP,       /**< N�pov�da */
  CCOMP,        /**< Komprimovat. */
  CDECOMP,      /**< Dekomprimovat. */
};

/** Chybov� hl�en� odpov�daj�c� chybov�m k�d�m. */
const char *ECODEMSG[] =
{
  /* EOK */
  "V�e v po��dku.\n",
  /* ECLWRONG */
  "Chybn� parametry p��kazov�ho ��dku!\n",

  "CHYBA ! vstup nesm� obsahovat ��slo!\n",
};

const char *HELPMSG =
  "Program Jednoduch� komprese.\n"
  "Autor: Martin Jany� 2010\n"
  "Program umi komprimovat nebo dekomprimovat text\n"
  "podle parametr� zadan�ch z p��kazov�ho ��dku.\n"
  "Pou�it�: proj1 -h\n"
  "         proj1 -c N\n"
  "         proj1 -d N\n"
  "Popis parametr�: -h  Napov�da\n"
  "                 -c  Komprese\n"
  "                 -d  Dekomprese\n"
  "                 N   Parametr pro kopresy a dekompresy\n"
  ;


/**
 * Struktura obsahuj�c� hodnoty parametr� p��kazov� ��dky.
 */
typedef struct params
{
  unsigned int N;   /**< Hodnota N z p��kazov� ��dky. */
  int ecode;        /**< Chybov� k�d programu, odpov�d� v��tu tecodes. */
  int state;        /**< Stavov� k�d programu, odpov�d� v��tu tstates. */
} TParams;

/**
 * Vytiskne hl�en� odpov�daj�c� chybov�mu k�du.
 * @param ecode k�d chyby programu
 */
void printECode(int ecode)
{
  if (ecode < EOK || ecode > EUNKNOWN)
  { ecode = EUNKNOWN; }

  fprintf(stderr, "%s", ECODEMSG[ecode]);
}



/**
 * Zpracuje argumenty p��kazov�ho ��dku a vr�t� je ve struktu�e TParams.
 * Pokud je form�t argument� chybn�, ukon�� program s chybov�m k�dem.
 * @param argc Po�et argument�.
 * @param argv Pole textov�ch �et�zc� s argumenty.
 * @return Vrac� analyzovan� argumenty p��kazov�ho ��dku.
 */
TParams getParams(int argc, char *argv[])
{
  TParams result =
  {
    .ecode = EOK,
    .state = CCOMP,
  };

  if (argc == 2 && strcmp("-h", argv[1]) == 0)
  { // tisk n�pov�dy
    result.state = CHELP;
  }
  else if (argc == 3)
  {
    int test = strtod(argv[2], NULL);

    if(test==0){
      result.ecode = ECLWRONG;
    }

    if (strcmp("-d", argv[1]) == 0){
      result.state = CDECOMP;

    }
    else if (strcmp("-c", argv[1]) == 0){

      result.state = CCOMP;
    }

    else{
      result.ecode = ECLWRONG;
    }

  }
  else
  { // p��li� mnoho parametr�
    result.ecode = ECLWRONG;
  }

  return result;
}

//////////DEKOMPRESE///////

int dekomprese(int N)
{
int c;
int i;
int hodnota;
int buffer[N];

while((c = getchar()) != EOF){


    if(isdigit(c)){
      hodnota = (int)(c-48); //prevot char na int, pocet opakovani tisku
      for(i=0; i < N; i++){
        buffer[i] = getchar(); // plneni pole
        if(isdigit(buffer[i])){
         printf("\t CHYBA ! vstup nesm� obsahovat cislo v dekomprimacnim bloku! ");
         return EXIT_FAILURE;
        }
        if(isdigit(buffer[i])){
            printf("\t Chybn� vstup!");
          return EXIT_FAILURE;
        }
      }

      for(i=0; i < hodnota; i++){ // opakovani vypisu buferu
        int ii;
        for(ii=0; ii < N ; ii++){ //vypis bufferu
          putchar(buffer[ii]);
        }
      }
  } // endif

  if(isdigit(c)==0){
    putchar(c);
  }


}
return 0; //endwhile
}

/////////////KOMPRESE/////////////


int komprese(int N)
{
  int i;
  int buffer1[N];
  int buffer2[N];
  int tisk[N];
  int pocet = '1';
  int ii = 0;
  const int limit = '9';

// plneni bufferu
  for(i = 0; i < N; i++){
    buffer1[i] = getchar();
      if(isdigit(buffer1[i])){
         printf("\t CHYBA ! vstup nesm� obsahovat ��slo!");
         return EXIT_FAILURE;
        }
      if(buffer1[i] == EOF){
        for(i = 0; i < N; i++){
          putchar(buffer1[i]);
        }
      break;
      }
  }
  /*
  for(i = 0; i < N; i++){
    putchar(buffer1[i]);
  }
*/

// plneni 2. bufferu znaky
  for(i = 0; i < N; i++){
    buffer2[i] = getchar();
    if(isdigit(buffer2[i])){
      printf("\t CHYBA ! vstup nesm� obsahovat ��slo!");
      return EXIT_FAILURE;
      }
    if(buffer2[i] == EOF){
        for(i = 0; i < N; i++){
          putchar(buffer1[i]);
        }
        for(i = 0; i < N; i++){

          putchar(buffer2[i]);
        }
      break;
      }
  }

tisk[0] = 0;
// mam naplneny dva buffery 
// mam naplneny dva buffery 
do{
//porovnavej
  if((memcmp(buffer1, buffer2, N * sizeof(int))) == 0){
  //printf("shoda ");
pocet++;
  if(pocet == limit){
    if(pocet != '1'){
      putchar(pocet);
    }
    pocet = '1';

    for(i = 0; i < N; i++){
      putchar(tisk[i]);
    }
    for(i =0; i < N; i++)
      buffer1[i] = buffer2[i];

    for(i =0; i < N; i++){
      buffer2[i] = getchar();

      if(isdigit(buffer2[i])){
          printf("\t CHYBA ! vstup nesm� obsahovat ��slo!");
        return EXIT_FAILURE;
      }

      ii++;
      if(buffer2[i] == '\n'){
        break;
      }
    }
  tisk[0] = 0;
  }


  for(i = 0; i < N; i++)
    tisk[i] = buffer1[i];

  for(i = 0; i < N; i++)
    buffer1[i] = buffer2[i];

  for(i = 0; i < N; i++){
    buffer2[i] = getchar();
    ii=i;
    if(isdigit(buffer2[i])){
        printf("\t Chybn� vstup!");
      return EXIT_FAILURE;
      }

    if(buffer2[i] == '\n'){

      if(pocet != '1'){
        putchar(pocet);
      }
      pocet = '1';

      for(i = 0; i < N; i++){
        putchar(tisk[i]);
      }
      tisk[0] = 0;
// ->>>>>

      for(i = 0; i < N; i++){
        if(i<=ii){
          putchar(buffer2[i]);
        }
        ii--;
      }
      //printf("%d", ii);

   // printf("270");
      return 0;
    }
  }
  }//if

  if((memcmp(buffer1, buffer2, N * sizeof(int))) != 0){
 //printf("neshoda ");

    if(tisk[0] > 0){
      if(pocet != '1'){
        putchar(pocet);
      }

    pocet = '1';
    for(i = 0; i < N; i++){
      putchar(tisk[i]);
    }
    for(i =0; i < N; i++)
      buffer1[i] = buffer2[i];

    for(i = 0; i < N; i++){
      buffer2[i] = getchar();
      if(isdigit(buffer2[i])){
          printf("\t CHYBA ! vstup nesm� obsahovat ��slo!");
        return EXIT_FAILURE;
      }
      if(buffer2[i] == '\n'){
        for(i = 0;i < N;i++){
          putchar(buffer2[i]);
        }
      break;
      }
    }
  tisk[0] = 0;
  } //if tisk

  putchar(buffer1[0]);

  for(i = 0;i < (N - 1); i++){
    buffer1[i] = buffer1[(i+1)];
  }

  buffer1[(N-1)] = buffer2[0];

  for(i = 0; i < (N - 1); i++){
    buffer2[i] = buffer2[(i+1)];
}

  buffer2[(N-1)] = getchar();
    if(isdigit(buffer2[i])){
      printf("\t CHYBA ! vstup nesm� obsahovat ��slo!");
      return EXIT_FAILURE;
      }
    if(buffer2[(N-1)] == '\n'){
      for(i = 0; i < N; i++){
        putchar(buffer1[i]);
      }
      for(i = 0; i < N; i++){
        putchar(buffer2[i]);
      }
      break;
    }

  } // if neshoda

} while(1);

return 0;


}
/////////////////////////////////////////////////////////////////
/**
 * Hlavn� program.
 */
int main(int argc, char *argv[])
{
  TParams params = getParams(argc, argv);
  if (params.ecode != EOK)
  { // n�co nestandardn�ho
    printECode(params.ecode);
    return EXIT_FAILURE;
  }

  if (params.state == CHELP)
  {
    printf("%s", HELPMSG);
    return EXIT_SUCCESS;
  }

    int N = atoi(argv[2]);


//
//  Sem pat�� vol�n� funkc�, kter� zajist� zadanou funk�nost a o�et�en�
//  chybov�ch stav�.
//

if (params.state == CCOMP)
 {
 komprese(N);
 }
 if (params.state == CDECOMP)
 {
 dekomprese(N);
 }
//   errcode = compress(params.N);

//  else ...

  return EXIT_SUCCESS;
}

/* konec proj1-kostra.c */
