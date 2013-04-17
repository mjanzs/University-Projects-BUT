/*
 * File:   io.c
 * Reseni  IJC-DU2, priklad 2
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 4. dubna 2011
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>
#include <stdbool.h>
#include "htable.h"

/**
 * cte slovo
 * @param s retezec
 * @param max maximalni pocet znaku
 * @param f vstup
 * @return delka retezce, EOF == 0
 */
int fgetword(char *s, int max, FILE *f) {

  static bool error_printed = false;
  char c, test;
  int i = 0;

  while((c = fgetc(f)) != EOF) {
    if(i < max-1) {
      if (i == 0 && isspace(c)) //mezery nazacatku
        continue;
      if (i != 0 && isspace(c)) { //mezera za slovem
        break;
      }
      s[i] = c;
      i++;
    }
    else {
	  if (error_printed != true) { //may fail .. pouze jedna chyba osetrena -> may repaired
        error_printed = true;
        fprintf(stderr, "Varovani: Slovo/slova delsi nez 255 znaku bylo oseknuto na tuto hodnotu\n");
      }
	  while(!isspace(test = fgetc(f)) && test != EOF) // preskoceni konce dlouheho slova
        ;
      break;
    }
      //s[i] = '\0';
  } 

  s[i] = '\0';

  return i;
}
