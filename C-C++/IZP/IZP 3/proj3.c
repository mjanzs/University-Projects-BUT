/*
 * Soubor:  proj3.c
 * Datum:   2010/12/1
 * Autor:   Martin Janyö, xjanys00@stud.fit.vutbr.cz
 * Projekt: Projekt c.3 - maticove operace
 * Popis:   Program provadi operace nad maticemi.
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define VECTORID 1
#define MATICEID 2
#define VEKTORMATICID 3

#define OK 0

#define FALSE 0
#define TRUE 1


/** KÛdy chyb programu */
enum tecodes
{
  EOK = 0,     /**< Bez chyby */
  ECLWRONG,    /**< Chybn˝ p¯Ìkazov˝ ¯·dek. */
  _EFILE,
  _EOPEN,
  _EOPER,
  _EMEM,
  _ERR,
  _ECOUNT,
};

/** StavovÈ kÛdy programu */
enum tstates
{
  CHELP,       /**< N·povÏda */
  CTEST,
  CVADD,
  CVSCAL,
  CMMULT,
  CMEXPR,
  CEIGHT,
  CBUBBLES,
  CEXTRA,
};

/** Chybov· hl·πenÌ odpovÌdajÌcÌ chybov˝m kÛd˘m. */
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
  "Nedostatek pameti\n"
  };

const char *HELPMSG =
  "Program Maticove operace.\n"
  "Autor: Martin Janys (c) 2010\n"
  "Program provadi zadane operace nad maticemi\n"
  "Pouziti: proj3 -h\n"
  "         proj3 --test\n"
  "         proj3 --vadd a.txt b.txt\n"
  "         proj3 --vscal a.txt b.txt\n"
  "         proj3 --vmmult A.txt B.txt\n"
  "         proj3 --mexpr A.txt B.txt\n"
  "         proj3 --eight v.txt M.txt\n"
  "         proj3 --bubbles M.txt\n"
  "         proj3 --extbubbles M3D.txt\n";

/**
 * Struktura obsahujÌcÌ hodnoty vektoru.
 */
 typedef struct tvect{
  int delka;
  int*vect;
 } TVect;
/**
 * Struktura obsahujÌcÌ hodnoty matice.
 */
typedef struct tmatice{
  int radky;
  int sloup;
  int**mat;
} TMatice;
/**
 * Struktura obsahujÌcÌ hodnoty vektoru matic.
 */
typedef struct tvmat{
  int radky;
  int sloup;
  int hloubka;
  int***vmat;
} TVmat;
/**
 * Struktura obsahujÌcÌ indexy prvku a posuny v matici/vektoru matic.
 */
typedef struct tcord{
  int radky;
  int sloup;
  int hloubka;
  int shifts; //horizontalne
  int shiftr; //vertikalne
  int shifth;  //forward a back
} TCoord;

/**
 * Struktura obsahujÌcÌ hodnoty parametr˘ p¯ÌkazovÈ ¯·dky.
 */
typedef struct params
{
  int ecode;        /**< Chybov˝ kÛd programu, odpovÌd· v˝Ëtu tecodes. */
  int state;        /**< Stavov˝ kÛd programu, odpovÌd· v˝Ëtu tstates. */
  char*soubor1;
  char*soubor2;
} TParams;

/**
 * Vytiskne hl·öenÌ odpovÌdajÌcÌ chybovÈmu kÛdu.
 * @param ecode kÛd chyby programu
 */
void printECode(int ecode)
{
  fprintf(stderr, "%s", ECODEMSG[ecode]);
}

void findBubble(TMatice*mat, TCoord*coord);
void findBubble3D(TVmat*vmat, TCoord*coord);

/**
 * Zpracuje argumenty p¯ÌkazovÈho ¯·dku a vr·tÌ je ve struktu¯e TParams.
 * Pokud je form·t argument˘ chybn˝, ukonËÌ program s chybov˝m kÛdem.
 * @param argc PoËet argument˘.
 * @param argv Pole textov˝ch ¯etÏzc˘ s argumenty.
 * @return VracÌ analyzovanÈ argumenty p¯ÌkazovÈho ¯·dku.
 */
TParams getParams(int argc, char*argv[])
{
  TParams result =
  { // inicializace struktury
    .ecode = EOK,
    .state = CTEST,
    .soubor1 = 0,
    .soubor2 = 0,
  };

  if (argc == 2 && strcmp("-h", argv[1]) == 0)
  { // tisk n·povÏdy
    result.state = CHELP;
  }
  else if (argc == 3)
  {
    if (strcmp("--test", argv[1]) == 0){
      result.state = CTEST;
      result.soubor1 = argv[2];
    }
    else if (strcmp("--bubbles", argv[1]) == 0){
      result.state = CBUBBLES;
      result.soubor1 = argv[2];
    }
    else if (strcmp("--extbubbles", argv[1]) == 0){
      result.state = CEXTRA;
      result.soubor1 = argv[2];
    }
    else{
      result.ecode = ECLWRONG;
      }
  }
  else if (argc == 4){
    if (strcmp("--vadd", argv[1]) == 0){
      result.state = CVADD;
      result.soubor1 = argv[2];
      result.soubor2 = argv[3];
    }
    else if (strcmp("--vscal", argv[1]) == 0){
      result.state = CVSCAL;
      result.soubor1 = argv[2];
      result.soubor2 = argv[3];
    }
    else if (strcmp("--mmult", argv[1]) == 0){
      result.state = CMMULT;
      result.soubor1 = argv[2];
      result.soubor2 = argv[3];
    }
    else if (strcmp("--mexpr", argv[1]) == 0){
      result.state = CMEXPR;
      result.soubor1 = argv[2];
      result.soubor2 = argv[3];
    }
    else if (strcmp("--eight", argv[1]) == 0){
      result.state = CEIGHT;
      result.soubor1 = argv[2];
      result.soubor2 = argv[3];
    }
    else{
      result.ecode = ECLWRONG;
    }
  }
  else
  { // p¯Ìliπ mnoho parametr˘
    result.ecode = ECLWRONG;
  }

  return result;
}
/**
 * UvolÚuje pamÏù vektoru matic.
 * @param vmat vektor matic.
 */
void freeVmat(TVmat*vmat){

    for (int i = 0; i < vmat->hloubka; i++){
      for (int j = 0; j < vmat->radky; j++){
        free(vmat->vmat[i][j]);
      }
      free(vmat->vmat[i]);
    }
    free(vmat->vmat);
}
/**
 * Vypisuje vektor.
 * @param vector
 */
void writeVect(TVect*vector){

  printf("%d\n", VECTORID);
  printf("%d\n", vector->delka);

  for (int i = 0; i < vector->delka; i++)
    printf("%d ", vector->vect[i]);

  printf("\n");
}
/**
 * UvolÚuje pamÏù matice.
 * @param mat matice.
 */
void freeMatice(TMatice*mat){

    for (int i = 0; i < mat->radky; i++)
      free(mat->mat[i]);

    free(mat->mat);

}
/**
 * Funkce naËÌt· matici ze souboru.
 * P¯Ì chybÏ v souboru po sobÏ uvolÚuje pamÏù.
 * @param fr ukazatel na soubor.
 * @param mat matice.
 * @return Error code.
 */
int getMat(FILE*fr,TMatice*mat)
{
  int status, pom;

  status = fscanf(fr, "%d", &mat->radky);
  if (status != 1){
    return _EFILE;
  }
  if (mat->radky <= 0)
    return _EFILE;

  status = fscanf(fr, "%d", &mat->sloup);
  if (status != 1){
    return _EFILE;
  }
  if (mat->sloup <= 0)
    return _EFILE;

  mat->mat = calloc(mat->radky, sizeof(int));
  if (mat->mat == NULL){
    return _EMEM;
  }

  for (int i = 0; i < mat->radky; i++){
    mat->mat[i] = calloc(mat->sloup, sizeof(int));
    if (mat->mat[i] == NULL){
      mat->radky = i;
      freeMatice(mat);
      return _EMEM;
    }
  }

  for (int i = 0; i < mat->radky; i++){
    for (int ii = 0; ii < mat->sloup; ii++){
      status = fscanf(fr, "%d", &mat->mat[i][ii]);
      if (status != 1){
        freeMatice(mat);
        return _EFILE;
      }
    }
  }

  status = fscanf(fr, "%d", &pom);

  if (status != EOF){
    freeMatice(mat);
    return _EFILE;
  }

  return OK;
}
/**
 * V˝pis matice ve spr·vnÈm tvaru.
 * @param mat matice
 */
void writeMat(TMatice*mat){

  printf("%d\n", MATICEID);
  printf("%d %d", mat->radky, mat->sloup);

  for (int i=0;i<mat->radky;i++){
    printf("\n");
    for (int ii = 0; ii < mat->sloup; ii++){
      printf("%d ", mat->mat[i][ii]);
    }
  }
  printf("\n");
}
/**
 * NaËÌt· a alokuje vektor.
 * P¯i chybÏ ve vstupnÌm souboru po sobÏ uvolnÌ pamÏù.
 * @param fr ukazatel na soubor.
 * @param vect vektor.
 * @return Error code.
 */
int getVector(FILE*fr, TVect*vect)
{
  int status, pom;

  status = fscanf(fr, "%d", &vect->delka);
  if (status != 1){
    return _EFILE;
  }
  if (vect->delka <= 0)
    return _EFILE;

  vect->vect = calloc(vect->delka, sizeof(int));
  if (vect->vect == NULL){
    return _EMEM;
  }

  for (int i = 0; i<vect->delka; i++){
    status = fscanf(fr, "%d", &vect->vect[i]);
    if (status != 1){
      free(vect->vect);
      return _EFILE;
    }
  }

  status = fscanf(fr, "%d", &pom);
  if (status != EOF){
    free(vect->vect);
    return _EFILE;
  }
  return OK;
}
/**
 * SËÌta dva vektory.
 * P¯i chybÏ v operaci (rozdÌlnÈ dÈlky) uvolnÌ pamÏt.
 * @param vect1 vektor
 * @param vect2 vektor
 * @param vysledek vektor
 * @return Error code.
 */
int addVect(TVect*vect1, TVect*vect2, TVect*vysledek){
  if (vect1->delka != vect2->delka){
    //fprintf(stderr,"False\n");
    free(vect1->vect);
    free(vect2->vect);
    return _EOPER;
  }

  vysledek->delka = vect1->delka;
  vysledek->vect = calloc(vect1->delka, sizeof(int));

  for (int i = 0; i < vect1->delka; i++)
    vysledek->vect[i] = vect1->vect[i] + vect2->vect[i];

  return OK;
}
/**
 * PoËÌt· skal·rnÌ souËin vektor˘.
 * P¯i chybÏ v operaci (rozdÌlnÈ dÈlky) uvolnÌ pamÏt.
 * @param vect1 vektor
 * @param vect2 vektor
 * @param vysledek vektor
 * @return Error code.
 */
int scalVect(TVect*vecta, TVect*vectb, int*vysledek)
{
  if (vecta->delka != vectb->delka){
    free(vecta->vect);
    free(vectb->vect);
    return _EOPER;
  }

  for (int i = 0; i < vecta->delka; i++)
    (*vysledek) = (*vysledek) + (vecta->vect[i] * vectb->vect[i]);

  return OK;
}
/**
 * Prov·dÌ maticov˝ souËin matic.
 * P¯i chybÏ v operaci uvolnÌ pamÏt.
 * @param mat1 matice
 * @param mat2 matice
 * @param vysledek matice
 * @return Error code.
 */
int soucinMat(TMatice*mat1, TMatice*mat2, TMatice*vysledek){

  vysledek->radky = mat1->radky;
  vysledek->sloup = mat2->sloup;

  if (mat1->sloup != mat2->radky){
    return _EOPER;
  }

  vysledek->mat = calloc(vysledek->radky, sizeof(*vysledek));
    for (int i = 0; i < vysledek->radky; i++)
      vysledek->mat[i] = calloc(vysledek->sloup, sizeof(int));

    for (int i = 0; i < mat1->radky; i++){
      for (int j = 0; j < mat2->sloup; j++){
        vysledek->mat[i][j] = 0;
        for (int k = 0; k <  mat2->radky; k++)
          vysledek->mat[i][j] += mat1->mat[i][k] * mat2->mat[k][j];
      }
    }

  return OK;
}
/**
 * Hled· vektor v 8mi smÏrech.
 * Porovn·v· ho s vektorem zadan˝m.
 * @param vect vektor
 * @param coord struktura
 * @param mat matice
 * @param cmp vektor na porovnavani //predava se aby se nealokoval pri kazdem volani fce
 * @return Error code / TRUE nalezen / FALSE nenalezen.
 */
int vectorsEight(TVect*vect, TCoord*coord, TMatice*mat, TVect*cmp){

  int idxr = coord->radky;// - coord->shiftr;
  int idxs = coord->sloup;// - coord->shiftr;
  int result;

  for (int i = 0; i < vect->delka; i++){
    cmp->vect[i] = mat->mat[idxr][idxs];
    idxr += coord->shiftr;
    idxs += coord->shifts;
  }

  result = memcmp(cmp->vect, vect->vect, vect->delka * sizeof(int));

  if (result == 0){
    return TRUE;
  }

  return FALSE;
}
/**
 * Vol· funkci pro hled·nÌ vektor˘.
 * Obsahuje podmÌnky pro rozsah pole.
 * Stanovuje posuny v matici.
 * @param mat matice
 * @param vect vektor
 * @param idxr index radku, kde byl nalezen 1. prvek hledanÈho vektoru
 * @param idxr index sloupce, kde byl nalezen 1. prvek hledanÈho vektoru
 * @return TRUE nalezen / FALSE nenalezen.
 */
int searchVect(TMatice*mat,TVect*vect,int idxr,int idxs){
// V - vychod Z - zapad etc
  TCoord coord;
  TVect cmp;
  coord.radky = idxr;
  coord.sloup = idxs;

  int status;
  cmp.delka = vect->delka;
  cmp.vect = calloc(cmp.delka, sizeof(int));
  if (cmp.vect == NULL)
    return _EMEM;

//1 V
  if (idxs + vect->delka <= mat->sloup) {
    coord.shiftr = 0;
    coord.shifts = 1;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }
//2 Z
  if ((idxs+1) >= vect->delka) {
    coord.shiftr = 0;
    coord.shifts = -1;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }
//3 SV
  if (((idxr+1) >= vect->delka) && ((idxs+vect->delka) <= mat->sloup)) {
    coord.shiftr = -1;
    coord.shifts = 1;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }
//4 SZ
  if ((idxr+1 >= vect->delka) && (idxs+1 >= vect->delka)) {
    coord.shiftr = -1;
    coord.shifts = -1;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }
//5 S
  if ((idxr+1) >= vect->delka) {
    coord.shiftr = -1;
    coord.shifts = 0;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }
//6 J
  if ((idxr+ + vect->delka) <= mat->radky) {
    coord.shiftr = 1;
    coord.shifts = 0;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }
//7 JV
  if (((idxr + vect->delka) <= mat->radky) && (idxs + vect->delka) <= mat->sloup) {
    coord.shiftr = 1;
    coord.shifts = 1;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }
//8  JZ
  if ((idxr + vect->delka <= mat->radky) && ((idxs+1) >= vect->delka)){
    coord.shiftr = 1;
    coord.shifts = -1;

    status = vectorsEight(vect, &coord, mat, &cmp);
    if (status == TRUE){
      free(cmp.vect);
      return TRUE;
    }
  }

  free(cmp.vect);

  return FALSE; //nenalezen
}
/**
 * Hled· 1. prvek vektoru v matici.
 * @param maat matice.
 * @param vect vektor.
 * @return TRUE nalezen / FALSE nenalezen.
 */
int searchPointEight(TMatice*maat, TVect*vect){

  int i, ii, result;

    for (i = 0; i < maat->radky; i++){
      for (ii = 0; ii < maat->sloup; ii++){
        if (maat->mat[i][ii] == vect->vect[0]){

          result = searchVect(maat, vect, i, ii);
          if (result == TRUE)
            return TRUE; // nalezen
        }
      }
    }

  return FALSE; // nenalezen
}
/**
 * Posunuje se v matici a vyskrtava prvky na kter˝ch uû program byl.
 * Vsechny projdute prvky se nastavuji na TRUE.
 * SpoustÌ rekurzy.
 * @param mat matice.
 * @param coord struktura.
 */
void searchBubble(TMatice*mat, TCoord coord){

  int idxr = coord.radky + coord.shiftr;
  int idxs = coord.sloup + coord.shifts;

  if ((mat->mat[idxr][idxs] == 0) && (mat->mat[idxr][idxs] != TRUE)){
    mat->mat[idxr][idxs] = TRUE;
    coord.radky = idxr;
    coord.sloup = idxs;
    findBubble(mat, &coord);
  }

  if (mat->mat[idxr][idxs] > 0){
    mat->mat[idxr][idxs] = TRUE;
  }
}
/**
 * Nastavuje posuny v matici.
 * Rekurze.
 * @param mat matice.
 * @param coord struktura.
 */
void findBubble(TMatice*mat, TCoord*coord){

  int idxr = coord->radky;
  int idxs = coord->sloup;

  if ((idxr + 1) < mat->radky) {
    coord->shiftr = 1;
    coord->shifts = 0;
    searchBubble(mat, *coord);
  }

  if (idxr > 0){
    coord->shiftr = -1;
    coord->shifts = 0;
    searchBubble(mat, *coord);
  }

  if (idxs > 0){
    coord->shiftr = 0;
    coord->shifts = -1;
    searchBubble(mat, *coord);
  }

  if ((idxs + 1) < mat->sloup){
    coord->shiftr = 0;
    coord->shifts = 1;
    searchBubble(mat, *coord);
  }

}
/**
 * Nastavuje pozici nuly v matici.
 * Vsechny projdute prvky se nastavuji na TRUE.
 * SpouötÌ rekurzy.
 * @param mat matice.
 * @param coord struktura.
 * @param pocet pocet bublin
 * @return Error code.
 */
int bubbles(TMatice*mat, TCoord*coord, int*pocet){

  (*pocet) = 0;

  for (int i = 0; i < mat->radky; i++){
    for (int ii = 0; ii < mat->sloup; ii++){
      if (mat->mat[i][ii] > 0){
        mat->mat[i][ii] = TRUE;
      }
      if (mat->mat[i][ii] == 0 && mat->mat[i][ii] != TRUE){    //false polozka ktera nebyla kontrolovana
          mat->mat[i][ii] = TRUE;                             //true zkontrolovana
          (*pocet)++;
          coord->radky = i;
          coord->sloup = ii;
          findBubble(mat, coord);
      }
      if (mat->mat[i][ii] < 0){
        return _EOPER;        // matice obsahuje zaporne prvky .. v rozporu se zadanim
      }
    }
  }

  return OK;
}
/**
 * Vypisuje matici.
 * @param mat.
 */
void writeVmat(TVmat*vmat){

  printf("%d\n", VEKTORMATICID);
  printf("%d %d %d\n", vmat->hloubka, vmat->radky, vmat->sloup);

  for (int i = 0; i < vmat->hloubka; i++){
		for (int j = 0; j < vmat->radky; j++){
			for (int k = 0; k < vmat->sloup; k++){
				printf("%d",vmat->vmat[i][j][k]);
			}
			printf("\n");
		}
		printf("\n");
  }
}
/**
 * NaËÌt· vektor matic a alokuje.
 * P¯i chybÏ uvonÌ pamÏù.
 * @param fr ukazatel na soubor.
 * @param vmat vektor matic.
 * @return Error code.
 */
int getVMat(FILE*fr, TVmat*vmat)
{
  int status, pom;

  status = fscanf(fr, "%d", &vmat->hloubka);
  if (status != 1)
    return _EFILE;
  if (vmat->hloubka <= 0)
    return _EFILE;

  status = fscanf(fr, "%d", &vmat->radky);
  if (status != 1)
    return _EFILE;
  if (vmat->radky <= 0)
    return _EFILE;

  status = fscanf(fr, "%d", &vmat->sloup);
  if (status != 1)
    return _EFILE;
  if (vmat->sloup <= 0)
    return _EFILE;

  vmat->vmat = calloc(vmat->hloubka, sizeof(int **));

  for (int i = 0 ;  i < vmat->hloubka; i++) {
    vmat->vmat[i] = calloc(vmat->radky, sizeof(int *));

    for (int j = 0; j < vmat->radky; j++)
      vmat->vmat[i][j] = calloc(vmat->sloup, sizeof(int));
  }

  for (int i = 0; i < vmat->hloubka; i++)
		for (int j = 0; j < vmat->radky; j++)
			for (int k = 0; k < vmat->sloup; k++){
				status = fscanf(fr, "%d", &vmat->vmat[i][j][k]);
        if (status != 1){
          freeVmat(vmat);
          return _EFILE;
        }
			}

  status = fscanf(fr, "%d", &pom);

  if (status != EOF){
    freeVmat(vmat);
    return _EFILE;
  }

  return OK;
}
/**
 * Otevre soubor a zjistÌ jeho prvnÌ prvek (typ).
 * @param typ.
 * @param soubor jmeno souboru.
 */
FILE*fileOpen(int*typ, char*soubor){

  int status;
  FILE*fr;
  if ((fr = fopen(soubor, "r")) == NULL) {
    printECode(_EOPEN);
    return NULL;
  }

  status = fscanf(fr, "%d", typ);
  if (status != 1){
    printECode(_EFILE);
    fclose(fr);
    return NULL;
  }

  return fr;
}
/**
 * Posunuje se ve vektoru matic a vyskrtava prvky na kter˝ch uû program byl.
 * SpoustÌ rekurzy.
 * @param vmat vektor matic.
 * @param coord struktura.
 */
void search3DBubble(TVmat*vmat, TCoord coord){

  int idxm = coord.hloubka + coord.shifth;
  int idxr = coord.radky + coord.shiftr;
  int idxs = coord.sloup + coord.shifts;

  if ((vmat->vmat[idxm][idxr][idxs] == 0) && (vmat->vmat[idxm][idxr][idxs] != TRUE)){
    vmat->vmat[idxm][idxr][idxs] = TRUE;
    coord.radky = idxr;
    coord.sloup = idxs;
    coord.hloubka = idxm;
    findBubble3D(vmat, &coord);
  }

  if ((vmat->vmat[idxm][idxr][idxs]) > 0){
    vmat->vmat[idxm][idxr][idxs] = TRUE;
  }

}
/**
 * Nastavuje posuny ve vektoru matic.
 * Rekurze.
 * @param vmat vektor matic.
 * @param coord struktura.
 */
void findBubble3D(TVmat*vmat, TCoord*coord){

  int idxr = coord->radky;
  int idxs = coord->sloup;
  int idxm = coord->hloubka;
// dolu
  if ((idxr + 1) < vmat->radky){
    coord->shiftr = 1;
    coord->shifts = 0;
    coord->shifth = 0;
    search3DBubble(vmat, *coord);
  }
// dopraca
  if ((idxs+1) < vmat->sloup){
    coord->shiftr = 0;
    coord->shifts = 1;
    coord->shifth = 0;
    search3DBubble(vmat, *coord);
  }
// doleva
  if (idxs > 0){
    coord->shiftr = 0;
    coord->shifts = -1;
    coord->shifth = 0;
    search3DBubble(vmat, *coord);
  }
// nahoru
  if (idxr > 0){
    coord->shiftr = -1;
    coord->shifts = 0;
    coord->shifth = 0;
    search3DBubble(vmat, *coord);
  }
// dopredu
  if ((idxm + 1) < vmat->hloubka){
    coord->shiftr = 0;
    coord->shifts = 0;
    coord->shifth = 1;
    search3DBubble(vmat, *coord);
  }
// dozadu
  if (idxm > 0){
    coord->shiftr = 0;
    coord->shifts = 0;
    coord->shifth = -1;
    search3DBubble(vmat, *coord);
  }
}
/**
 * Nastavuje posuny ve vektoru matic.
 * Rekurze.
 * @param pocet pocet bublin
 * @param vmat vektor matic.
 * @param coord struktura.
 */
int bubbles3D(TVmat*vmat, TCoord*coord, int*pocet){

  (*pocet) = 0;

  for (int i = 0; i < vmat->hloubka; i++){
    for (int j = 0; j < vmat->radky; j++){
      for (int k = 0; k < vmat->sloup; k++){

        if ((vmat->vmat[i][j][k]) > 0){
          vmat->vmat[i][j][k] = TRUE;
        }

        if ((vmat->vmat[i][j][k] == 0) && (vmat->vmat[i][j][k] != TRUE)){
          vmat->vmat[i][j][k] = TRUE;
          (*pocet)++;
          coord->hloubka = i;
          coord->radky = j;
          coord->sloup = k;
          //printf("%d %d %d\n", i,j,k);
          findBubble3D(vmat, coord);
        }
        if ((vmat->vmat[i][j][k]) < 0){
          return _EOPER;
        }
      }
    }
  }
  return OK;
}
/**
 * Testuje soubor.
 * @param soubor jmeno souboru.
 * @return Error code.
 */
int test(char*soubor){

  int typ, status;

  FILE*fr;

  fr = fileOpen(&typ, soubor);
  if (fr==NULL)
    return _ERR;

  if (typ == VECTORID){
    TVect vect;
    status = getVector(fr, &vect);
    if (status == _EFILE){
      fclose(fr);
      return _EFILE;
    }
    if (status == _EMEM){
      fclose(fr);
      return _EMEM;
    }
    fclose(fr);
    writeVect(&vect);
    free(vect.vect);
//vector end
    return OK;
  }
//matice
  if (typ == MATICEID){
  TMatice mat1;
    status = getMat(fr, &mat1);
    if (status == _EFILE){
      //printf("x");
      fclose(fr);
      //freeMatice(mat1.mat,mat1.radky);
      return _EFILE;
    }
    writeMat(&mat1);
    freeMatice(&mat1);
    fclose(fr);
    return OK;
  }
//matice end
  if (typ == VEKTORMATICID){
    TVmat vmat;
    status = getVMat(fr, &vmat);
    if (status == _EFILE){
      fclose(fr);
      return _EFILE;
    }

    writeVmat(&vmat);
    freeVmat(&vmat);
    fclose(fr);
    return OK;
  }
  else{
    fclose(fr);
    return _EFILE;
  }

  fclose(fr);
  return OK;
}
/**
 * Vol·nÌ vektorovÈho souËtu.
 * @param params struktura parametru.
 * @return Error code.
 */
int callVADD(TParams*params){

  int typ, status;

  FILE*fr1;
  FILE*fr2;

  TVect vect1;
  TVect vect2;
  TVect vysledek;
//1.vector Start
  fr1 = fileOpen(&typ, params->soubor1);
  if (fr1 == NULL){
    return _ERR;
  }

  if (typ != VECTORID){
    fclose(fr1);
    return _EFILE;
  }

  status = getVector(fr1, &vect1);
  if (status == _EFILE){
    fclose(fr1);
    return _EFILE;
  }
//1. vector end
  fclose(fr1);
//2. vector start
  fr2 = fileOpen(&typ, params->soubor2);
  if (fr2 == NULL){
    free(vect1.vect);
    return _ERR;
  }
  if (typ != VECTORID){
    fclose(fr2);
    free(vect1.vect);
    return _EFILE;
  }
  status = getVector(fr2, &vect2);
  if (status == _EFILE){
    free(vect1.vect);
    fclose(fr2);
    return _EFILE;
  }

  status = addVect(&vect1, &vect2, &vysledek);
  if (status == _EOPER){
    fclose(fr2);
    return _EOPER;
  }

  writeVect(&vysledek);
//uvoneni pameti
  free(vect1.vect);
  free(vect2.vect);
  free(vysledek.vect);
  fclose(fr2);

  return OK;
}
/**
 * Vol·nÌ skal·rnÌho souËinu.
 * @param params struktura parametru.
 * @return Error code.
 */
int callVSCAL(TParams*params){

  int typ, status;
  int vysledek = 0;

  FILE*fr1;
  FILE*fr2;

  TVect vect1;
  TVect vect2;

//1.vector Start
  fr1 = fileOpen(&typ, params->soubor1);
  if (fr1 == NULL){
    return _ERR;
  }
  if (typ != VECTORID){
    fclose(fr1);
    return _EFILE;
  }
  status = getVector(fr1, &vect1);
    if (status == _EFILE){
      fclose(fr1);
      return _EFILE;
    }
    fclose(fr1);
//1. vector end
//2. vector start
  fr2 = fileOpen(&typ, params->soubor2);
  if (fr2 == NULL){
    free(vect1.vect);
    fclose(fr2);
    return _ERR;
  }
  if (typ != VECTORID){
    fclose(fr2);
    return _EFILE;
  }

  status = getVector(fr2,&vect2);
  if (status == _EFILE){
    free(vect1.vect);
    fclose(fr2);
    return _EFILE;
  }

  status = scalVect(&vect1, &vect2, &vysledek);
  if (status == _EOPER)
    fclose(fr2);
    return _EOPER;

  printf("%d\n", vysledek);
//2. vector end
//uvolneni pameti
    free(vect1.vect);
    free(vect2.vect);
    fclose(fr2);
  return EOK;
}
/**
 * Vol·nÌ souËinu matic.
 * @param params struktura parametru.
 * @return Error code.
 */
int callMMULT(TParams*params){

  int typ, status;

  FILE*fr1;
  FILE*fr2;

  TMatice mat1;
  TMatice mat2;
  TMatice vysledek;

//1. matice start
  fr1 = fileOpen(&typ, params->soubor1);
  if (fr1 == NULL){
    return _ERR;
  }
  if (typ != MATICEID){
    fclose(fr1);
    return _EFILE;
  }

  status = getMat(fr1,&mat1);

  if (status == _EFILE){
    fclose(fr1);
    return _EFILE;
  }

//1. matice end
  fclose(fr1);
//2. matice start
  fr2 = fileOpen(&typ, params->soubor2);
  if (fr2 == NULL){
    freeMatice(&mat1);
    return _ERR;
  }

  if (typ != MATICEID){
    fclose(fr2);
    freeMatice(&mat1);
    return _EFILE;
  }

  status = getMat(fr2, &mat2);

  if (status == _EFILE){
    freeMatice(&mat1);
    fclose(fr2);
    return _EFILE;
  }
//2. matice end
  fclose(fr2);

  status = soucinMat(&mat1, &mat2, &vysledek);
  if (status == _EOPER){
    freeMatice(&mat1);
    freeMatice(&mat2);
    return _EOPER;
  }
  writeMat(&vysledek);
//uvolneni pameti
  freeMatice(&mat1);
  freeMatice(&mat2);
  freeMatice(&vysledek);

  return OK;
}
/**
 * Vol·nÌ v˝poËtu maticovÈho v˝razu.
 * @param params struktura parametru.
 * @return Error code.
 */
int callMEXPR(TParams*params){

  int typ, status;

  FILE*fr1;
  FILE*fr2;

  TMatice mat1;
  TMatice mat2;
  TMatice vysledek;
  TMatice vyraz;
//1. matice start
  fr1 = fileOpen(&typ, params->soubor1);

  if (fr1 == NULL){
    return _ERR;
  }
  if (typ != MATICEID){
    fclose(fr1);
    return _EFILE;
  }

  status = getMat(fr1, &mat1);
  if (status == _EFILE){
    fclose(fr1);
    return _EFILE;
  }
//1. matice end
  fclose(fr1);
//2. matice start
  fr2 = fileOpen(&typ, params->soubor2);
  if (fr2 == NULL){
    freeMatice(&mat1);
    return _ERR;
  }
  if (typ != MATICEID){
    fclose(fr2);
    freeMatice(&mat1);
    return _EFILE;
  }

  status = getMat(fr2, &mat2);

  if (status == _EFILE){
    freeMatice(&mat1);
    fclose(fr2);
    return _EFILE;
  }
//2. matice end
  fclose(fr2);

  status = soucinMat(&mat1, &mat2, &vysledek);
  if (status == _EOPER){
    freeMatice(&mat1);
    freeMatice(&mat2);
    return _EOPER;
  }

  status = soucinMat(&vysledek, &mat1, &vyraz);

  if (status == _EOPER){
    freeMatice(&mat1);
    freeMatice(&mat2);
    freeMatice(&vysledek);
    return _EOPER;
  }

  writeMat(&vyraz);
//uvolneni pameti
  freeMatice(&mat1);
  freeMatice(&mat2);
  freeMatice(&vysledek);
  freeMatice(&vyraz);

  return OK;
}
/**
 * Vol·nÌ osmismerky.
 * @param params struktura parametru.
 * @return Error code.
 */
int callEIGHT(TParams*params){

  int typ, status;

  FILE*fr1;
  FILE*fr2;

  TMatice mat1;
  TVect vect;
//vector Start
  fr1 = fileOpen(&typ, params->soubor1);
  if (fr1 == NULL){
    return _ERR;
  }
  if (typ != VECTORID){
    fclose(fr1);
    return _EFILE;
  }

  status = getVector(fr1, &vect);
  if (status == _EFILE){
    fclose(fr1);
    return _EFILE;
  }
  fclose(fr1);
//vector end
//matice start
  fr2 = fileOpen(&typ, params->soubor2);
  if (fr2 == NULL){
    free(vect.vect);
    return _ERR;
  }
  if (typ != MATICEID){
    fclose(fr2);
    free(vect.vect);
    return _EFILE;
  }

  status = getMat(fr2,&mat1);
  if (status == _EFILE){
    free(vect.vect);
    fclose(fr2);
    return _EFILE;
  }
//matice end
  fclose(fr2);

  status = searchPointEight(&mat1, &vect);

  if (status == TRUE)
    printf("true\n");
  else
    printf("false\n");

  freeMatice(&mat1);
  free(vect.vect);

  return OK;
}
/**
 * Vol·nÌ fce bublin.
 * @param params struktura parametru.
 * @return Error code.
 */
int callBUBBLES(TParams*params){

  int typ, status, pocet;

  FILE*fr;

  TMatice mat1;
  TCoord coord;
//matice start
  fr = fileOpen(&typ, params->soubor1);
  if (fr == NULL){
    return _ERR;
  }
  if (typ != MATICEID){
    fclose(fr);
    return _EFILE;
  }

  status = getMat(fr, &mat1);
  if (status == _EFILE){
    fclose(fr);
    return _EFILE;
  }
//matice end
  fclose(fr);

  status = bubbles(&mat1, &coord, &pocet);
  if (status == _EOPER){
    freeMatice(&mat1);
    return _EOPER;
  }

  printf("%d\n", pocet);

  freeMatice(&mat1);

  return OK;
}
/**
 * Vol·nÌ vektorovÈho souËtu.
 * @param params struktura parametru.
 * @return Error code.
 */
int callEXTRA(TParams*params){

  int typ, status;
  int pocet = 0;

  FILE*fr;
  TVmat vmat;
  TCoord coord;

  fr = fileOpen(&typ, params->soubor1);
  if (fr == NULL){
    return _ERR;
  }
  if (typ != VEKTORMATICID){
    fclose(fr);
    return _EFILE;
  }

  status = getVMat(fr, &vmat);

  fclose(fr);

  status = bubbles3D(&vmat, &coord, &pocet);
  if(status == _EOPER){
    freeVmat(&vmat);
    return _EOPER;
  }

  printf("%d\n", pocet);

  freeVmat(&vmat);

  return OK;
}
/////////////////////////////////////////////////////////////////
/**
 * HlavnÌ program.
 */
int main(int argc, char *argv[])
{
  int status;

  TParams params = getParams(argc, argv);

  if (params.ecode != EOK)
  { // nÏco nestandardnÌho
    printECode(params.ecode);
    return EXIT_FAILURE;
  }
  switch (params.state){
/** HELP */
    case CHELP:
    {
      printf("%s", HELPMSG);
      return EXIT_SUCCESS;
    }
    break;

/** TEST */
    case CTEST:
    {
      status = test(params.soubor1);
    }
    break;

/** VEKTOROVY SOUCET */
    case CVADD:
    {
      status = callVADD(&params);
    }
    break;

/** SKALARNI SOUCIN */
    case CVSCAL:
    {
      status = callVSCAL(&params);
    }
    break;

/** SOUCIN MATIC */
    case CMMULT:
    {
      status = callMMULT(&params);
    }
    break;

/** MATICOVY VYRAZ A*B*A */
    case CMEXPR:
    {
      status = callMEXPR(&params);
    }
    break;

/** OSMISMERKA */
    case CEIGHT:
    {
      status = callEIGHT(&params);
    }
    break;

/** BUBLINY */
    case CBUBBLES:
    {
      status = callBUBBLES(&params);
    }
    break;

/** BUBLINY 3D */
    case CEXTRA:
    {
      status = callEXTRA(&params);
    }
    break;
  }

  if (status == _ERR) //chyba byla vyspsana uz driv ... jedna se o EOPEN
    return EXIT_FAILURE;

  if (status != OK) {
    printECode(status);
    return EXIT_FAILURE;
  }

  return EXIT_SUCCESS;
}

/* konec - proj3*/
