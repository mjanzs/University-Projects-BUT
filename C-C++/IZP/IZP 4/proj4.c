/*
 * Soubor:  proj3.c
 * Datum:   2010/12/1
 * Autor:   Martin Jany¹, xjanys00@stud.fit.vutbr.cz
 * Projekt: Projekt è.4 - Èeské øazení,
 * Popis:   Práce s jednosmìrnì vázaným seznamem. Èeské øazení.
 */

#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <string.h>
#include <ctype.h>
#include <stdbool.h>

#define znak_Ch '#'
#define znak_ch '@'
#define znak_CH '&'

#define MAXSTRLEN 35 //predpokladam ze polozky jako jmeno, primeni atd nebudou delsi jak 15 znaku + rezerva

#define OK 0

#define greater -1
#define less 1
#define equal 0

/**
 * Struktura dat seznamu.
 */
typedef struct item TItem;
struct item
{
  char*data;
  TItem *next;
};
/**
 * Struktura seznam.
 */
typedef struct list
{
  TItem *first;
} TList;
/**
 * Struktura hlavicky tabulky.
 */
typedef struct head
{
  int sirka;    /**< sirka hlavicky (pocet sloupcu) */
  int csloup;   /**< cislo sloupce pro tisk */
  int ckrit;    /**< cislo sloupce */
  char sloupec[MAXSTRLEN];  /**< jmeno sloupce pro tisk */
  char krit[MAXSTRLEN];     /**< jmeno sloupce pro kriterium after/before */
  char polozka[MAXSTRLEN];  /**< polozka ktera se ma ve sloupci ckrit hledat */

} THead;
/**
 * Tabulka pro primarni ceske razeni
 */
unsigned int tab1[] =
{
  [(unsigned char)'a'] = 1, [(unsigned char)'A'] = 1, [(unsigned char)'á'] = 1, [(unsigned char)'Á'] = 1,
  [(unsigned char)'b'] = 2, [(unsigned char)'B'] = 2,
  [(unsigned char)'c'] = 3, [(unsigned char)'C'] = 3,
  [(unsigned char)'è'] = 4, [(unsigned char)'È'] = 4,
  [(unsigned char)'d'] = 5, [(unsigned char)'D'] = 5, [(unsigned char)'ï'] = 5, [(unsigned char)'Ï'] = 5,
  [(unsigned char)'e'] = 6, [(unsigned char)'E'] = 6, [(unsigned char)'é'] = 6, [(unsigned char)'É'] = 6, [(unsigned char)'ì'] = 6, [(unsigned char)'Ì'] = 6,
  [(unsigned char)'f'] = 7, [(unsigned char)'F'] = 7,
  [(unsigned char)'g'] = 8, [(unsigned char)'G'] = 8,
  [(unsigned char)'h'] = 9, [(unsigned char)'H'] = 9,
  [(unsigned char)znak_ch] = 10, [(unsigned char)znak_Ch] = 10,
  [(unsigned char)'i'] = 11, [(unsigned char)'I'] = 11, [(unsigned char)'í'] = 11, [(unsigned char)'Í'] = 11,
  [(unsigned char)'j'] = 12, [(unsigned char)'J'] = 12,
  [(unsigned char)'k'] = 13, [(unsigned char)'K'] = 13,
  [(unsigned char)'l'] = 14, [(unsigned char)'L'] = 14,
  [(unsigned char)'m'] = 15, [(unsigned char)'M'] = 15,
  [(unsigned char)'n'] = 16, [(unsigned char)'N'] = 16, [(unsigned char)'ò'] = 16, [(unsigned char)'Ò'] = 16,
  [(unsigned char)'o'] = 17, [(unsigned char)'O'] = 17, [(unsigned char)'ó'] = 17, [(unsigned char)'Ó'] = 17,
  [(unsigned char)'p'] = 18, [(unsigned char)'P'] = 18,
  [(unsigned char)'q'] = 19, [(unsigned char)'Q'] = 19,
  [(unsigned char)'r'] = 20, [(unsigned char)'R'] = 20,
  [(unsigned char)'ø'] = 21, [(unsigned char)'Ø'] = 21,
  [(unsigned char)'s'] = 22, [(unsigned char)'S'] = 22,
  [(unsigned char)'¹'] = 23, [(unsigned char)'©'] = 23,
  [(unsigned char)'t'] = 24, [(unsigned char)'T'] = 24, [(unsigned char) '»'] = 24, [(unsigned char) '«'] = 24,
  [(unsigned char)'u'] = 25, [(unsigned char)'U'] = 25, [(unsigned char) 'ú'] = 25, [(unsigned char) 'Ú'] = 25, [(unsigned char) 'ù'] = 25, [(unsigned char) 'Ù'] = 25,
  [(unsigned char)'v'] = 26, [(unsigned char)'V'] = 26,
  [(unsigned char)'w'] = 27, [(unsigned char)'W'] = 27,
  [(unsigned char)'x'] = 28, [(unsigned char)'X'] = 28,
  [(unsigned char)'y'] = 29, [(unsigned char)'Y'] = 29, [(unsigned char) 'ý'] = 29, [(unsigned char) 'Ý'] = 29,
  [(unsigned char)'z'] = 30, [(unsigned char)'Z'] = 30,
  [(unsigned char)'¾'] = 31, [(unsigned char)'®'] = 31,
  [(unsigned char)'0'] = 32,
  [(unsigned char)'1'] = 33,
  [(unsigned char)'2'] = 34,
  [(unsigned char)'3'] = 35,
  [(unsigned char)'4'] = 36,
  [(unsigned char)'5'] = 37,
  [(unsigned char)'6'] = 38,
  [(unsigned char)'7'] = 39,
  [(unsigned char)'8'] = 40,
  [(unsigned char)'9'] = 41,

};
/**
 * Tabulka pro sekundarni ceske razeni
 */
unsigned int tab2[] =
{
  [(unsigned char)'a'] = 1, [(unsigned char)'A'] = 1,
  [(unsigned char)'á'] = 2, [(unsigned char)'Á'] = 2,
  [(unsigned char)'b'] = 3, [(unsigned char)'B'] = 3,
  [(unsigned char)'c'] = 4, [(unsigned char)'C'] = 4,
  [(unsigned char)'è'] = 5, [(unsigned char)'È'] = 5,
  [(unsigned char)'d'] = 6, [(unsigned char)'D'] = 6,
  [(unsigned char)'ï'] = 7, [(unsigned char)'Ï'] = 7,
  [(unsigned char)'e'] = 8, [(unsigned char)'E'] = 8,
  [(unsigned char)'é'] = 9, [(unsigned char)'É'] = 9,
  [(unsigned char)'ì'] = 10, [(unsigned char)'Ì'] = 10,
  [(unsigned char)'f'] = 11, [(unsigned char)'F'] = 11,
  [(unsigned char)'g'] = 12, [(unsigned char)'G'] = 12,
  [(unsigned char)'h'] = 13, [(unsigned char)'H'] = 13,
  [(unsigned char)znak_ch] = 14, [(unsigned char) znak_Ch] = 14,
  [(unsigned char)'i'] = 15, [(unsigned char)'I'] = 15,
  [(unsigned char)'í'] = 16, [(unsigned char)'Í'] = 16,
  [(unsigned char)'j'] = 17, [(unsigned char)'J'] = 17,
  [(unsigned char)'k'] = 18, [(unsigned char)'K'] = 18,
  [(unsigned char)'l'] = 19, [(unsigned char)'L'] = 19,
  [(unsigned char)'m'] = 20, [(unsigned char)'M'] = 20,
  [(unsigned char)'n'] = 21, [(unsigned char)'N'] = 21,
  [(unsigned char)'ò'] = 22, [(unsigned char)'Ò'] = 22,
  [(unsigned char)'o'] = 23, [(unsigned char)'O'] = 23,
  [(unsigned char)'ó'] = 24, [(unsigned char)'Ó'] = 24,
  [(unsigned char)'p'] = 25, [(unsigned char)'P'] = 25,
  [(unsigned char)'q'] = 26, [(unsigned char)'Q'] = 26,
  [(unsigned char)'r'] = 27, [(unsigned char)'R'] = 27,
  [(unsigned char)'ø'] = 28, [(unsigned char)'Ø'] = 28,
  [(unsigned char)'s'] = 29, [(unsigned char)'S'] = 29,
  [(unsigned char)'¹'] = 30, [(unsigned char)'©'] = 30,
  [(unsigned char)'t'] = 31, [(unsigned char)'T'] = 31,
  [(unsigned char)'»'] = 32, [(unsigned char)'«'] = 32,
  [(unsigned char)'u'] = 33, [(unsigned char)'U'] = 33,
  [(unsigned char)'ú'] = 34, [(unsigned char)'Ú'] = 34,
  [(unsigned char)'ù'] = 35, [(unsigned char)'Ù'] = 35,
  [(unsigned char)'v'] = 36, [(unsigned char)'V'] = 36,
  [(unsigned char)'w'] = 37, [(unsigned char)'W'] = 37,
  [(unsigned char)'x'] = 38, [(unsigned char)'X'] = 38,
  [(unsigned char)'y'] = 39, [(unsigned char)'Y'] = 39,
  [(unsigned char)'ý'] = 40, [(unsigned char)'Ý'] = 40,
  [(unsigned char)'z'] = 41, [(unsigned char)'Z'] = 41,
  [(unsigned char)'¾'] = 42, [(unsigned char)'®'] = 42,
  [(unsigned char)'0'] = 43,
  [(unsigned char)'1'] = 44,
  [(unsigned char)'2'] = 45,
  [(unsigned char)'3'] = 46,
  [(unsigned char)'4'] = 47,
  [(unsigned char)'5'] = 48,
  [(unsigned char)'6'] = 49,
  [(unsigned char)'7'] = 50,
  [(unsigned char)'8'] = 51,
  [(unsigned char)'9'] = 52,
};

/** Kódy chyb programu */
enum returns
{
  EOK = 0,     /**< Bez chyby */
  ECLWRONG,    /**< Chybný pøíkazový øádek. */
  _EFILE,
  _EOPEN,
  _EOPER,
  _EMEM,
  _ECLOSE,
  _EFILEHEAD,
  _ERR,
  _ECOUNT,
  ENDOFLINE,
  LNFINISHED,
};

/** Stavové kódy programu */
enum tstates
{
  CHELP,
  CPRINT,
  CPRINTOPT,      /**< Nápovìda */
};
/**
 * Struktura obsahující hodnoty parametrù pøíkazové øádky.
 */
typedef struct params
{
  int ecode;        /**< Chybový kód programu, odpovídá výètu returns. */
  int state;        /**< Stavový kód programu, odpovídá výètu tstates. */
  char*fsource;     /**< Zdrojovy soubor */
  char*fdest;       /**< Cilovy soubor */
  char sloup[MAXSTRLEN];        /**< Jmeno sloupce pro tisk */
  char headKrit[MAXSTRLEN];     /**< Jmeno sloupce pro kriterium */
  char polozkaKrit[MAXSTRLEN];  /**< Pokozka kriteria */
  bool print;
  bool sort;
  bool usort;
  bool after;
  bool before;

} TParams;
/** Chybová hlášení odpovídající chybovým kódùm. */
const char *ECODEMSG[] =
{
  /* EOK */
  "Vse v poradku.\n",
  /* ECLWRONG */
  "Chybne parametry prikazoveho radku!\n",
  /* EFILE */
  "Chyba ve vstupnim souboru\n",
  /* EOPEN */
  "Soubor se nepodarilo otevrit\n",
  /* EOPER */
  "false\n",
  /* EMEM */
  "Nedostatek pameti\n",
  /* ECLOSE*/
  "Soubor se nepodarilo uzavrit\n",
  /* EFILEHEAD */
  "Retezce v parametrech programu se nenalezaji v hlavicce tabulky\n",
};

const char *HELPMSG =
  "Program Ceske razeni.\n"
  "Autor: Martin Janys (c) 2010\n"
  "Projekt c.4\n"
  "Parametry:   --print sloupec"
  "             --before sloupec retezec\n"
  "             --after sloupec retezec\n"
  "             --sort\n"
  "\n"
  "             --print je povinny parametr\n"
  "             ostatni jsou nepovinne\n";


/**
 * Vytiskne hlá?ení odpovídající chybovému kódu.
 * @param ecode kód chyby programu
 */
void printECode(int ecode)
{
  fprintf(stderr, "%s", ECODEMSG[ecode]);
}


/**
 * Zpracuje argumenty pøíkazového øádku a vrátí je ve struktuøe TParams.
 * Pokud je formát argumentù chybný, ukonèí program s chybovým kódem.
 * @param argc Poèet argumentù.
 * @param argv Pole textových øetìzcù s argumenty.
 * @return Vrací analyzované argumenty pøíkazového øádku.
 */
TParams getParams(int argc, char*argv[])
{
  int i;
  TParams result =
  { // inicializace struktury
    .ecode = ECLWRONG,
    .state = CPRINT,
    .fsource = 0,
    .fdest = 0,
    .headKrit[0] = 0, //inicializace jako "prazdny" retezec
    .sort = false,
    .after = false,
    .before = false,
  };

  if (argc == 2 && strcmp("-h", argv[1]) == 0)
  { // tisk nápovìdy
    result.ecode = EOK;
    result.state = CHELP;
    return result;
  }
  for (i = 1; i < (argc-2); i++){
    result.ecode = EOK;
    if (strcmp("--before", argv[i]) == 0){
      result.before = true; //printf("before mam\n");
      result.state = CPRINTOPT;
      i++;
      if(i >= (argc-2)){
        result.ecode = ECLWRONG;
        break;
      }
      strncpy(result.headKrit, argv[i], MAXSTRLEN);
      i++;
      if (i >= (argc-2)){
        result.ecode = ECLWRONG;
        break;
      }
      strncpy(result.polozkaKrit, argv[i], MAXSTRLEN);
      //printf("->>%s\n",result.polozkaKrit);
    }

    else if (strcmp("--after", argv[i]) == 0){
      result.after = true; //printf("after mam\n");
      result.state = CPRINTOPT;
      i++;
      if (i >= (argc-2)){
        result.ecode = ECLWRONG;
        break;
      }
      strncpy(result.headKrit, argv[i], MAXSTRLEN);
      i++;
      if (i >= argc){
        result.ecode = ECLWRONG;
        break;
      }
      strncpy(result.polozkaKrit,argv[i], MAXSTRLEN);
      //printf("->>%s\n",result.polozkaKrit);
    }

    else if (strcmp("--print", argv[i]) == 0){
      result.ecode = EOK;
      if (result.after != true && result.before != true)
        result.state = CPRINT;
      result.print = true;
      i++;//printf("print mam\n");
      if (i >= (argc-2)){
        result.ecode = ECLWRONG;
        break;
      }
      strncpy(result.sloup, argv[i], MAXSTRLEN);

    }
    else if (strcmp("--sort", argv[i]) == 0){
      result.sort = true;//printf("sort mam\n");
    }
    else if (strcmp("--usort", argv[i]) == 0){
      result.usort = true;//printf("usort mam\n");
    }
    else{
      result.ecode = ECLWRONG;
      break;
    }
  }

  result.fsource = argv[i];
  i++;
  result.fdest = argv[i];

  if (result.print ==  false)
    result.ecode = ECLWRONG;
  //osetreni vylucnych parametru
  if (result.after ==  true && result.before == true)
    result.ecode = ECLWRONG;
  if (result.sort ==  true && result.usort == true)
    result.ecode = ECLWRONG;

  return result;
}
/**
 * Inicializace seznamu
 * @param list Seznam.
 */
void listInit(TList*list){

  assert(list != NULL);
  list->first = NULL;

}

void listDeleteFirst(TList *list){

  assert(list != NULL);
  assert(list->first != NULL);

  TItem*item;
  item = list->first;
  free(item->data);
  list->first = item->next;
  free(item);
}
/**
 * Alokace nového prvku seznamu
 * @param data Data, ktera chceme do saznamu pridavat.
 */
TItem *itemNew(const char* data){

  TItem *item = malloc(sizeof(TItem));
  if (item == NULL)
    return NULL;
  if (item != NULL) {
    item->data = malloc(sizeof(char) * MAXSTRLEN);  //musel jsem prejit na dynamickou allokaci, pri staticke byl nutny sort pres strncpy (toto reseni program nakonec zrychlilo)
    strncpy(item->data, data, MAXSTRLEN);
  }
  item->next = NULL;
  return item;
}
/**
 * Vlozeni noveho prvku do seznamu
 * @param list Seznam.
 * @param item Polozka, kterou pridavame do seznamu.
 */
void listInsetFirst(TList *list, TItem *item){

  assert(list != NULL);
  assert(item != NULL);
  item->next = list->first;
  list->first = item;
  //item->next = NULL;
}
/**
 * Uvolneni seznamu
 * @param list Seznam
 */
void listFree(TList*list){

  assert(list != NULL);

  while (list->first != NULL)
    listDeleteFirst(list);
}
/**
 * Provadi reverzy saznamu, aby byl vytisknut ve spravnem poradi
 * @param list seznam
 */
void revList(TList* list)
{
  TItem *temp,*current,*result;
  temp = NULL;
  result = NULL;
  current = list->first;
  while(current != NULL) {
    temp = current->next;
    current->next = result;
    result = current;
    current = temp;
  }
  list->first=result;
}
/**
 * Srovnava dva ceske vstupni retezce
 * @param a 1. retezec
 * @param b 2. retezec
 * @return vetsi/mensi/rovno
 */
int cmpStrings(char a[MAXSTRLEN], char b[MAXSTRLEN]){

  int i = 0;
  int aLen, bLen;
//primarni razeni
  while(a[i] != '\0' && b[i] != '\0')
  {
    if(tab1[(unsigned char) a[i]] < tab1[(unsigned char) b[i]]){
      return greater;
    }
    else if(tab1[(unsigned char) a[i]] > tab1[(unsigned char) b[i]]){
      return less;
    }
    else i++;
  }
//porovnavani delky
  aLen = strlen(a);
  bLen = strlen(b);

  if(aLen > bLen) return less;
  if(aLen < bLen) return greater;
//druhe razeni
  while(a[i] != '\0' && b[i] != '\0')
  {
    if(tab2[(unsigned char) a[i]] < tab2[(unsigned char) b[i]]){
      return greater;
    }
    else if(tab2[(unsigned char) a[i]] > tab2[(unsigned char) b[i]]){
      return less;
    }
    else i++;
  }

  return equal;
}
/**
 * Setrideni seznamu podle cestke abecedy
 * V opacnem poradi, aby nebyla nutna reverze pred tiskem.
 * @param list seznam
 */
void listSort(TList *list) {
//bubblesort
  char*pom;
  bool swap = true;

  if (list->first == NULL) //seznam je prazdny
    return;

  while (swap) {
    swap = false;
    for (TItem *itemb = list->first; itemb->next != NULL; itemb = itemb->next){
      if ((cmpStrings(itemb->data, itemb->next->data)) > 0){
        swap = true;
        pom = itemb->next->data;
        itemb->next->data = itemb->data;
        itemb->data = pom;
      }
    }
  }
}
/**
 * Maze polozku seznamu.
 * Funkce je pouzita v USort.
 * @param del polozka ktera ma byt vymazana
 */
void deleteItem(TItem*del) {

  TItem*tmp = del->next->next;

  if (del->next != NULL)
    free(del->next->data);
    free(del->next);
  del->next = tmp;

}
/**
 * Unikatni setrideni seznamu podle cestke abecedy
 * V opacnem poradi, aby nebyla nutna reverze pred tiskem.
 * @param list seznam
 */
void listUSort(TList *list) {

  char*pom;
  bool swap = true;

  while (swap) {
    swap = false;
    for (TItem *itemb = list->first; itemb->next != NULL; itemb = itemb->next){
      if ((cmpStrings(itemb->data, itemb->next->data)) == 0){ //stejne prvky se "vyskrtaji"
        swap = true;
        deleteItem(itemb);
      }
      if ((cmpStrings(itemb->data, itemb->next->data)) > 0){
        swap = true;
        pom = itemb->next->data;
        itemb->next->data = itemb->data;
        itemb->data = pom;
      }
    }
  }
}
/**
 * Ète retezce ze souboru.
 * Vynechava bile znaky.
 * 'ch' nahrazuje znakem znak_ch
 * @param fr ukazatel na vstupni soubor
 * @param polozka ziskany retezec
 * @return ENDOFLINE (konec radku, ktery skoncil '\n')
           LNFINISHED (konec radku, pred '\n' se nelezali pouze bile znaky)
 */
int readString(FILE*fr, char*polozka){

  int c = 0;
  int prev = ' ';
  int i = 0;
  int status = ENDOFLINE;

  while((c = fgetc(fr)) != EOF && i < MAXSTRLEN-1){

    if (c == '\n') {

      if (isspace(prev)){
        status = LNFINISHED;
        break;
      }

      status = ENDOFLINE;
      break;
    }
    else if (isspace(c)){
      if (isspace(prev)){
        continue;
      }
      status = OK;
      prev = c;
      break;
    }
    else if (c == 'h' && prev == 'c'){
      i--;
      polozka[i] = znak_ch;
      i++;
    }
    else if (c == 'h' && prev == 'C'){
      i--;
      polozka[i] = znak_Ch;
      i++;
    }
    else if (c == 'H' && prev == 'C'){
      i--;
      polozka[i] = znak_CH;
      i++;
    }
    else{
      polozka[i] = c;
      i++;
      prev = c;
    }
  }
  polozka[i] = 0;

  return status;
}
/**
 * Vypis retezce do souboru
 * Misto znak_ch vypisuje 'c' 'h' apod
 * @param str retezec, ktery ma vypsat
 * @param fw cilovy soubor
 */
void writeString(char str[MAXSTRLEN], FILE*fw){

  int i = 0;

  while (str[i] != 0) {
    if (str[i] == znak_ch) {
      putc('c', fw);
      putc('h', fw);
      i++;
    }
    else if (str[i] == znak_Ch) {
      putc('C', fw);
      putc('h', fw);
      i++;
    }
    else if (str[i] == znak_CH) {
      putc('C', fw);
      putc('H', fw);
      i++;
    }
    else {
      putc(str[i], fw);
      i++;
    }
  }
  putc('\n', fw);
}
/**
 * Precte prvni radek souboru (hlavicku)
 * Nastastavi strukturu Thead (pocet sloupcu, cisla sloupcu, se kterymi budeme pracovat)
 * @param fr vstupni soubor
 * @param head struktura hlavicky tabulky
 * @return Error code
 */
int readHead(FILE*fr, THead*head){

  int status = OK;
  int pocet = 0;
  head->csloup = 0;
  head->ckrit = 0;
  char polozka[MAXSTRLEN] = "";

  while (status != ENDOFLINE) {
    pocet++;
    status = readString(fr, polozka);
    if (status == LNFINISHED) {
      pocet--;
      break;
    }
    if (cmpStrings(polozka, head->sloupec) == 0)
      head->csloup = pocet;
    if (cmpStrings(polozka, head->krit) == 0)
      head->ckrit = pocet;
  }
  if (head->csloup == 0)
    return _EFILEHEAD;
  if (head->krit[0] != 0 && head->ckrit == 0) //head->krit[0] == 0 tj ze parametry s kriteriem nebyl definovany
      return _EFILEHEAD;


  head->sirka = pocet;

  return OK;
}
/**
 * Nacte pozadovany sloupec do seznamu
 * @param fr zdrojovy soubor
 * @param list seznam
 * @param head struktura obsahujici udaje o hlavicce
 * @param pom pomocny retezec do ktereho se ukladaji data, ktera se pouziji v seznamu
 * @return Error code
 */
int getList(FILE*fr, TList*list, THead*head){

  TItem*item;
  int status = ENDOFLINE;
  int pocet = 0;
  char*pom = malloc(sizeof(char) * MAXSTRLEN);

  while(!feof(fr)){
    pocet++;
    for (int i = 1; i <= head->sirka; i++) {
      status = readString(fr, pom);
      if (status != ENDOFLINE && head->sirka == i) {
        status = readString(fr, pom);
        if (status == LNFINISHED)
          break;
        fprintf(stderr, "Radek %d. - spatny pocet slupcu. ", pocet);
        listFree(list);
        free(pom);
        return _EFILE;
      }
      if (i == head->csloup){
        item = itemNew(pom);
        if (item == NULL) {
          listFree(list);
          free(pom);
          return _EMEM;
        }
        assert(item != NULL);
        listInsetFirst(list, item);
      }
    }
  }
  free(pom);
  return OK;
}
/**
 * Nacte pozadovany sloupec do seznamu s parametrem before/after
 * @param fr zdrojovy soubor
 * @param list seznam
 * @param head struktura obsahujici udaje o hlavicce
 * @param after true == param after, false == param before
 * @return Error code
 */
int getListAfterBefore(FILE*fr, TList*list, THead*head, bool after){

  TItem*item;
  char pom[MAXSTRLEN];  //pomocna polozka uklada se do pom1 2 nebo se obsah zahazuje
  char pom1[MAXSTRLEN]; //prcni nactena polozka
  char pom2[MAXSTRLEN]; //druha nactena polozka
  int status;
  int cpom1; // cislo prvniho sloupce, ktery bude nacitan
  int cpom2; // cislo druheho sloupce, ktery bude nacitan
  int pocet = 0;
/* algortimus : sloupce mohou byt zadany v ruznem poradi proto se tyto cisla sloupcu setridi,
 aby prvky seznamu mohli byt cteny poporade. Dale se tyto prvky ze seznamu vyberou a nazklade cisles sloupcu
 se spravny prvek porovna s prvkem z parametru a druhy prvek se na zaklade vyhodnoceni after/befor ulozi do seznamu*/

//setrideni cisel sloupcu podle velikosti
  if (head->csloup != head->ckrit) {
    cpom1 = (head->csloup < head->ckrit) ? head->csloup : head->ckrit;
    cpom2 = (head->csloup > head->ckrit) ? head->csloup : head->ckrit;
  }
  else {
    cpom1 = cpom2 = head->csloup;
  }

  while (!feof(fr)) {
    pocet++;
    for (int i = 1; i <= head->sirka; i++) {
      status = readString(fr, pom);
      if (status != ENDOFLINE && head->sirka == i) {
        status = readString(fr, pom);
        if (status == LNFINISHED)
          break;
        fprintf(stderr, "Radek %d. - spatny pocet slupcu. ", pocet);
        listFree(list);
        return _EFILE;
      }
      if (i == cpom1) { //pri odpovidajicim sloupci ulozeni do pom promenne
        strncpy(pom1, pom, MAXSTRLEN);
      }
      if (i == cpom2) { //pri odpovidajicim sloupci ulozeni do pom promenne
        strncpy(pom2, pom, MAXSTRLEN);
      }
    }
//ted to mozna bude vypadat jako opakujici kod ale meni se tam pom1/pom2 a </> =)
    if (head->csloup > head->ckrit) { //dotaz na to ktery sloupec byl kriterium a ktery pro print
      if (after == true) { //after
        if (cmpStrings(head->polozka, pom1) < 0) { //porovnani a pripadne ulozeni do seznamu
          item = itemNew(pom2);
          if (item == NULL) {
            listFree(list);
            return _EMEM;
          }
          assert(item != NULL);
          listInsetFirst(list, item);
        }
      }
      if (after == false){ //before
        if (cmpStrings(head->polozka, pom1) > 0) { //porovnani a pripadne ulozeni do seznamu
          item = itemNew(pom2);
            if (item == NULL) {
            listFree(list);
            return _EMEM;
          }
          assert(item != NULL);
          listInsetFirst(list, item);
        }
      }
    }
    if (head->csloup <= head->ckrit) { //dotaz na to ktery sloupec byl kriterium a ktery pro print
      if (after == true) { //after
        if (cmpStrings(head->polozka, pom2) < 0) { //porovnani a pripadne ulozeni do seznamu
          item = itemNew(pom1);
            if (item == NULL) {
            listFree(list);
            return _EMEM;
          }
          assert(item != NULL);
          listInsetFirst(list, item);
        }
      }
      if (after == false) { //before
        if (cmpStrings(head->polozka, pom2) > 0) { //porovnani a pripadne ulozeni do seznamu
          item = itemNew(pom1);
            if (item == NULL) {
            listFree(list);
            return _EMEM;
          }
          assert(item != NULL);
          listInsetFirst(list, item);
        }
      }
    }
  }

  return OK;
}
/**
 * Tiskne seznam
 * @param list seznam
 * @param dest cilovy soubor
 */
void listPrint(TList*list, char*dest) {

  TList print;
  listInit(&print);
  print.first = list->first;
  int pocet = 0;
  int status;

  FILE*fw = fopen(dest, "w");

  while (print.first != NULL) {
    pocet++;
    writeString(print.first->data, fw);
    print.first = print.first->next;
  }

  status = fclose(fw);
  if(status == EOF)
    printECode(_ECLOSE);
}
/////////////////////////////////////////////////////////////////
/**
 * Hlavní program.
 */
int main(int argc, char *argv[])
{
  TParams params = getParams(argc, argv);

  if (params.ecode != EOK) {
    printECode(params.ecode);
    return EXIT_FAILURE;
  }
/* HELP */
  if (params.state == CHELP) {
      printf("%s", HELPMSG);
      return EXIT_SUCCESS;
  }
/////////////////////////////////////////
  int status;
  TList list;
    listInit(&list);
  THead head;

  FILE*fr;
  if ((fr = fopen(params.fsource, "r")) == NULL){
    printECode(_EOPEN);
    return EXIT_FAILURE;
  }

  strncpy(head.krit, params.headKrit, MAXSTRLEN);
  strncpy(head.sloupec, params.sloup, MAXSTRLEN);
  strncpy(head.polozka, params.polozkaKrit, MAXSTRLEN);

  status = readHead(fr, &head);
  if (status != OK) {
    printECode(status);
    return EXIT_FAILURE;
  }
/* PRINT */
  if (params.state == CPRINT) {
    status = getList(fr, &list, &head);
    if (status != OK){
      printECode(status);
      fclose(fr);
      return EXIT_FAILURE;
    }
  }
/* AFTER / BEFORE */
  else if (params.state == CPRINTOPT) {
  /* AFTER */
    if(params.after == true){
      status = getListAfterBefore(fr, &list, &head, true); //true == after
      if (status != OK){
        printECode(status);
        fclose(fr);
        return EXIT_FAILURE;
    }
    }
  /* BEFORE */
    if (params.before == true) {
      status = getListAfterBefore(fr, &list, &head, false); //false == before
      if (status != OK){
        printECode(status);
        fclose(fr);
        return EXIT_FAILURE;
    }
    }
  }
/* SORT & PRINT */
  if (params.sort == true) {
    listSort(&list);
    listPrint(&list, params.fdest);
  }
/* USORT & PRINT */
  else if (params.usort == true) {
    listUSort(&list);
    listPrint(&list, params.fdest);
  }
/* PRINT */
  else {
    revList(&list);
    listPrint(&list, params.fdest);
  }

  listFree(&list);
  fclose(fr);
/////////////////////////////////////////

  return EXIT_SUCCESS;
}

/* konec - proj4*/
