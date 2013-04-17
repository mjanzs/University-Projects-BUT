/*
 * File:   htable_clear.c
 * Reseni  IJC-DU2, priklad 2
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 4. dubna 2011
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include "htable.h"

/**
 * maze zaznamy tabulky
 * @param t ukazatel na tabulku
 */
void htable_clear(htable_t* t) {
  
  struct htable_listitem* pom;
  
  for(int i = 0; i < (int)t->htable_size; i++){
   if(t->uk[i] != NULL) {
     while(t->uk[i] != NULL) {
       pom = t->uk[i]->next;
       free(t->uk[i]->key);
       free(t->uk[i]);
       t->uk[i] = pom;
     }
   }
  }
}
