/*
 * File:   htable_begin.c
 * Reseni  IJC-DU2, priklad 2
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 4. dubna 2011
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include <strings.h>
#include "htable.h"

/**
 * nalezne posledni iterator v tabulce
 * @param t ukazatel na tabulku
 * @return  iterator
 */
struct htable_iterator htable_begin(htable_t *t) {

  struct htable_iterator iterator;

  for(int i = 0; i < (int)t->htable_size; i++){
   if(t->uk[i] != NULL) {
     iterator.htptr = t;
     iterator.index = i;
     iterator.ptr = t->uk[i];
     return iterator;
   }
  }

  iterator.ptr = NULL;
  return iterator;
}