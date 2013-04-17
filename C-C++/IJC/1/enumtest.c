/* 
 * File:   enumtest.c
 * Øešení  IJC-DÚ, pøíklad a)
 * Author: Martin Janyš, FIT
 *
 * Pøeloženo: gcc 4.4.5 (Merlin)
 * Created on 17. bøezna 2011
 * 
 * Práce s výètovým typem. 
 * Identifikace mìsice.
 */

#include <stdio.h>
#include <stdlib.h>
#include <locale.h>
#include "enum.h"
#include "error.h"

/*
 *    Napi¹te testovací program "enumtest.c", kde ve funkci main
     - nejdøíve naètìte ze std vstupu jednu hodnotu a vytisknìte
     - potom vypisujte mìsíce do výstupního souboru
       dokud nedojde k chybovému ukonèení programu
 */
int main(void) { /* test - NEMÌNIT! */

  char *l = setlocale(LC_ALL,"cs_CZ.iso-8859-2");

  if(l==NULL)
    Error("setlocale: Nelze nastavit èeskou lokalizaci\n");

  enum months m;
  m = ReadMonth();     // ète mìsíc
  PrintMonthShort(m);  // tiskne krátké jméno
  printf("\n");
  PrintMonth(m);       // tiskne dlouhé jméno
  printf("\n\n");

  for( m = Leden; m < 15; m++ ) { // úmyslná chyba
    PrintMonthShort(m);
    printf("\n");
  }
  return 0;
}

