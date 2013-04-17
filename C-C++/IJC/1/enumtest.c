/* 
 * File:   enumtest.c
 * �e�en�  IJC-D�, p��klad a)
 * Author: Martin Jany�, FIT
 *
 * P�elo�eno: gcc 4.4.5 (Merlin)
 * Created on 17. b�ezna 2011
 * 
 * Pr�ce s v��tov�m typem. 
 * Identifikace m�sice.
 */

#include <stdio.h>
#include <stdlib.h>
#include <locale.h>
#include "enum.h"
#include "error.h"

/*
 *    Napi�te testovac� program "enumtest.c", kde ve funkci main
     - nejd��ve na�t�te ze std vstupu jednu hodnotu a vytiskn�te
     - potom vypisujte m�s�ce do v�stupn�ho souboru
       dokud nedojde k chybov�mu ukon�en� programu
 */
int main(void) { /* test - NEM�NIT! */

  char *l = setlocale(LC_ALL,"cs_CZ.iso-8859-2");

  if(l==NULL)
    Error("setlocale: Nelze nastavit �eskou lokalizaci\n");

  enum months m;
  m = ReadMonth();     // �te m�s�c
  PrintMonthShort(m);  // tiskne kr�tk� jm�no
  printf("\n");
  PrintMonth(m);       // tiskne dlouh� jm�no
  printf("\n\n");

  for( m = Leden; m < 15; m++ ) { // �mysln� chyba
    PrintMonthShort(m);
    printf("\n");
  }
  return 0;
}

