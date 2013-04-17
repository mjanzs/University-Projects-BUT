/*
 * File:   htable_init.c
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
 * vytvoření a inicializaci tabulky
 * @param htable_size velikost tabulky
 * @return ukazatel na tabulku
 */
htable_t* htable_init(unsigned htable_size) {

  htable_t* htable;
  htable = malloc(sizeof(htable_t));
  if (htable == NULL)
    return NULL;
  
  htable->htable_size = htable_size;

  htable->uk = malloc(htable_size * sizeof(struct htable_listitem*));
  if(htable->uk == NULL)
    return NULL;

  for(unsigned i = 0; i < htable_size; i++)
    htable->uk[i] = NULL;

  return htable;
}
