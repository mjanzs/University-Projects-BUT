/*
 * Soubor:  proj2.c
 * Datum:   2010/11/24
 * Autor:   Martin Janys, xjanys00@stud.fit.vutbr.cz
 * Projekt: Projekt �. 2 - Iteracni vypocty
 * Popis:   Program provadi v�po�et ruznych matematickych funkci pomoci iteracnich vypoctu.
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h> //strcmp
#include <math.h>
#include <float.h>


double presnost(double sigdig);
int scanNUM(double*x);
int scanVAHA(double*vaha);

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
  CHELP,        /**< N�pov�da */
  CTANH,        /**< tanh(x). */
  CLOGAX,       /**< loga(x). */
  CWAM,         /**< v�en� aritmetick� pr�m�r */
  CWQM          /**< v�en� kvadratick� pr�m�r */
};

/** Chybov� hl�en� odpov�daj�c� chybov�m k�d�m. */
const char *ECODEMSG[] =
{
  /* EOK */
  "Vse v poradku.\n",
  /* ECLWRONG */
  "Chybne parametry prikazoveho radku!\n"
  "Pouzite parametr -h\n",
};

const char *HELPMSG =
  "Program Iterecni vypocty.\n"
  "Autor: Martin Janys (c) 2010\n"
  "Program provadi vypocet ruznych matematick�ch funkci\n"
  "pomoci iteracnich vypoctu.\n"
  "Pouziti: proj2 -h\n"
  "         proj2 --tanh singdig\n"
  "         proj2 --logax sigdig a\n"
  "         proj2 --wam\n"
  "         proj2 --wqm\n"
  "Popis parametru:\n"
  "singdig  - pocet platnych cislic, prirozene cislo\n"
  "tanh     - hyperbolicky tangens\n"
  "logax    - logaritmus x o zakladu a, a > 0!\n"
  "a        - zaklad logaritmu\n"
  "wam      - vazeny aritmeticky prumer\n"
  "wqm      - vazeny kvadratick� prumer\n ";



/**
 * Struktura obsahuj�c� hodnoty parametr� p��kazov� ��dky.
 */
typedef struct params
{
  double sigdig;   /**< Hodnota sigdig z p��kazov� ��dky. */
  int ecode;        /**< Chybov� k�d programu, odpov�d� v��tu tecodes. */
  int state;      /**< Stavov� k�d programu, odpov�d� v��tu tstates. */
  double a;

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
  { // inicializace struktury
    .sigdig = 0,
    .ecode = EOK,
    .state = CTANH,
    .a = 0
  };



  if (argc == 2){
    if(strcmp("-h", argv[1]) == 0){ // tisk n�pov�dy
      result.state = CHELP;
    }
    else if(strcmp("--wam", argv[1]) == 0){ // tisk n�pov�dy
      result.state = CWAM;
    }
    else if(strcmp("--wqm", argv[1]) == 0){ // tisk n�pov�dy
      result.state = CWQM;
    }
    else{
      result.ecode = ECLWRONG;
    }
  }
  else if (argc == 3){
    if(strcmp("--tanh", argv[1]) == 0){
      result.state = CTANH;
      int test = strtod(argv[2], NULL); // osetre zda argv1 bude cislo
        test = ceil(test); // uprava na cela cisla
        //printf("%d", test);
        if(test==0){
          result.ecode = ECLWRONG;
        }
        else if(test < 0){
          result.ecode = ECLWRONG;
        }
        else if(test > DBL_DIG){
          fprintf(stderr,"Varovani prilis velka prenost program bude pracovat s nejvyssi moznou\n");
          result.sigdig = DBL_DIG;
        }
        else{
          result.ecode = EOK;
          result.sigdig = test;
        }
    }
    else{
      result.ecode = ECLWRONG;
    }
  }
  else if(argc == 4){
    if(strcmp("--logax", argv[1]) == 0){
      result.state = CLOGAX;
      double test = strtod(argv[2], NULL); // osetreni zda argv bude cislo
        test = ceil(test); // uprava na cela cisla
        if(test==0){
          result.ecode = ECLWRONG;
        }
        else if(test < 0){
          result.ecode = ECLWRONG;
        }
        else if(test > DBL_DIG){
          fprintf(stderr,"Varovani prilis velka prenost program bude pracovat s nejvyssi moznou\n");
          result.sigdig = DBL_DIG;
        }
        else{
          result.ecode = EOK;
          result.sigdig = test;
        }

      if(result.ecode == EOK){
        double test2 = strtod(argv[3], NULL); // osetreni zda argv bude cislo
        
        if(test2==0){
          result.ecode = ECLWRONG;
        }
        else if(test2 < 0){
          result.ecode = ECLWRONG;
        }
        else{
          result.ecode = EOK;
          result.a = test2;
        }
      }
    }
    else{ // prilis mnoho parametr�
      result.ecode = ECLWRONG;
    }
  }
  else{
    result.ecode = ECLWRONG;
  }
  return result;

}



/////////////////////////////////////////////////////////////////
/**
 * funkce hlavn�ho programu.
 */


double sinhyp(double eps, double x)  // funkce pro vypocet hyperbolickeho sinu
{
double k = x;
if(x<0) x *= -1;

  double y = 0;
  double yp = -1;
  double t0 = x;
  double ti;
  ti = t0;

  double i=0;
  while ((fabs(y-yp)) > eps ){
    i=i+1;
    ti = ti*((x*x)/(2*i*(2*i+1)));
    //printf("1 while %lg\n", ti);
    yp=y;
    y=y+ti;
    if(y>DBL_MAX) return DBL_MAX;     //preteceni double
  }
  double vysledek;
  if(x!=k){
    vysledek = -y-t0;
    return vysledek;
  }
  else{
    vysledek = y+t0;
    return vysledek;
  }
}

double coshyp(double eps, double x) // vypocet hyporbelickeho sinu
{
  double k = x;

  if(x<0) x *= -1;

  double y = 0;
  double yp = -1;
  double t0 = 1;
  double ti;
  ti = t0;

  double i=0;
  while ((fabs(y-yp)) > eps){
    i=i+1;
    ti = ti*((x*x)/((2*i)*(2*i-1)));
  
    yp=y;
    y=y+ti;
    if(y>DBL_MAX) return DBL_MAX;
  }
  double vysledek;
  if(k!=x){
    vysledek = -y-t0;
    return vysledek;
  }
  else{
    vysledek = y+t0;
    return vysledek;
  }
}


double hyptg(double sigdig, double x){  // hyperbolicky tangens

  if(x == 0) return 0;
  else if(x == INFINITY) return 1;
  else if(x == -INFINITY) return -1;
  else if(x == NAN) return NAN;
  double sin, cos;

  double eps = presnost(sigdig);

  sin= sinhyp(eps, x);
  cos= coshyp(eps, x);

  double tanh = sin/cos;
  if(x<0) return (tanh*-1);
  if(x>0) return tanh;

  return NAN;
}

double ln(double eps,double x) // prirozeny logaritmus
{

  double y = 0;
  double yp = -1;
  double t0 = (x-1)/x;
  double ti;
  ti = t0;

  int i=1;
  while ((fabs(y-yp)) > eps ){
    i=i+1;
    ti = ti*((((x-1)*(i-1)))/((i)*x));

    yp=y;
    y=y+ti;
  }
  double vysledek;
  vysledek = y+t0;

return vysledek;
}


double lnLINK(double eps,double x) // rozklad cisla pro exektivni logaritmovani
{
  const double z = 10;
  double e = 0;

  double vysledek;
  if(x>=1){           //rozklad na x * z na exponent
    while(x > 10){
      x = x/z;
      e++;
    }
  }

  else if(x<1){
    while(x < 9){
      x = x*z;
      e--;
    }
  }
  else{
    vysledek = ln(eps, x);
  return vysledek;
  }

  vysledek = ln(eps, x) + e * ln(eps, z);

return vysledek;
}

double logax(double sigdig, double a, double x){ //funkce obsahuje osetreni definicniho oboru
  double eps = presnost(sigdig);
    if(x == INFINITY) return INFINITY;
    if(x<0){
      fprintf(stderr, "Definicnim oborem logaritmu je R + \n");
      return -1;
    }
    if(x == 0){
      return -INFINITY;
    }
    if(a == x){
      return 1;
    }

    //if(x > 10e307) return INFINITY;

    double log = lnLINK(eps, x) / lnLINK(eps, a);

    return log;
}


double citatelWAM(double x, double h)
{
  static double result1=0;
    result1 = result1 + (x*h);

  return result1;
}

double jmenovatel(double h)
{
 
  static double result2=0;
  result2 = result2 + h;

  return result2;
}

double citatelWQM(double x, double h)
{
  static double result1=0;
  result1 = result1 + (x*x*h);

  return result1;
}

double WQM(){

  double cislo, vaha, c, j, wqm;
  int status = scanNUM(&cislo);

  if(status == EOF) return EOF;
  if(cislo == INFINITY) return INFINITY;

  status = scanNUM(&vaha);
  if(vaha == EOF){
    fprintf(stderr, "%lf",NAN);
    return EOF;
  }
  if(vaha == INFINITY) return INFINITY;

    c = citatelWQM(cislo,vaha);
    j = jmenovatel(vaha);

    wqm = sqrt(c/j);

  return wqm;
}

double WAM(){

  double cislo, vaha, c, j, wam;
    int status = scanNUM(&cislo);
      if(status == EOF) return EOF;
      if(cislo == INFINITY) return INFINITY;
    status = scanVAHA(&vaha);
      if(vaha == EOF){
        fprintf(stderr, "%lf",NAN);
        return EOF;
        }
      if(vaha == INFINITY) return INFINITY;

    c = citatelWAM(cislo,vaha);

    j = jmenovatel(vaha);

    wam = c/j;

    if(wam == INFINITY) return EXIT_SUCCESS;
 

  return wam;

}

double presnost(double sigdig){

  double eps = 1;
  for(double i = 0; i <= sigdig; i++) // sigdig -> eps
    eps = eps*0.1;
  //printf("\n%.10e\n", eps);
  return eps;
}

int scanNUM(double*num){ // overuje zda cislo neni nan
  int status;
  while(1){
    status = scanf("%lf", num);
        //status = scanf("%lf", num);
      if(status == EOF)
        return EOF;
      if(status<= 0){
        fprintf(stderr,"%lf\n", NAN);
        scanf("%*s");
        //eof = scanf("%lf", &num);
      }
      else break;
  }
return 0;
}

int scanVAHA(double*num){ // overuje zda cislo neni zaporne ci nan
  int status;
  while(1){
    status = scanf("%lf", num);
        //status = scanf("%lf", num);
      if(status == EOF)
        return EOF;
      if(status<= 0){
        fprintf(stderr,"%lf\n", NAN);
        scanf("%*s");
        //eof = scanf("%lf", &num);
      }
      else if(*num < 0){
        fprintf(stderr,"Vaha musi byt nezaporne cislo\n");
        //eof = scanf("%lf", &num);
      }
      else break;
  }
return 0;
}
///////////////////////////////////////////////////////////////////

int main(int argc, char *argv[])
{

  TParams params = getParams(argc, argv);
  if (params.ecode != EOK)
  { // n�co nestandardn�ho
    printECode(params.ecode);
    return EXIT_FAILURE;
  }

  else if (params.state == CHELP)
  {
    printf("%s", HELPMSG);
    return EXIT_SUCCESS;
  }

  else if (params.state == CTANH)
  {
    double x;
    double sigdig = params.sigdig;

    while(1){
      int status = scanNUM(&x);
      if(status==EOF) break;
      //printf("status %d x %lf\n", status,x);

      double tanh = hyptg(sigdig, x);

      if(tanh == NAN) break;
        printf("%.10e\n", tanh);
    
	
    }
  }
  else if (params.state == CLOGAX)
  {
	double a = params.a;
    double sigdig = params.sigdig;
    double x;
    while(1){
	
		int status = scanNUM(&x);
		if(status == EOF) return EXIT_SUCCESS;

		double log = logax(sigdig, a, x);

		if(log != -1) //nevypisuje zaporne hodnoty
			printf("%.10e\n", log);
	}
  }

  else if (params.state == CWAM)
  {
    while(1){
      double wam = WAM();
      if(wam == INFINITY){
        printf("%lf\n", INFINITY);
        return EXIT_SUCCESS;
      }
      if(wam == EOF) return EXIT_SUCCESS;
      printf("%.10e\n", wam);
    }
  }

  else if (params.state == CWQM)
  {
    while(1){
      double wqm = WQM();
      if(wqm == INFINITY){
        printf("%lf\n", INFINITY);
        return EXIT_SUCCESS;
      }
      if(wqm == EOF) return EXIT_SUCCESS;
      printf("%.10e\n", wqm);
	}
  }
  else{
    return EXIT_FAILURE;
  }
  return EXIT_SUCCESS;
}
