/*
 * File:   htable_end.c
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
 * nalezne posledni iterator v tabulce
 * @param t ukazatel na tabulku
 * @return  iterator
 */
struct htable_iterator htable_end(htable_t *t) {

  htable_listitem* pom;
  struct htable_iterator iterator;

  for(int i = (t->htable_size - 1); i >= 0; i--) {
    if(t->uk[i] != NULL) {
      for(struct htable_listitem* ii = t->uk[i]; ii != NULL; ii = ii->next) {
        pom = ii;
      }
      iterator.htptr = t;
      iterator.index = i;
      iterator.ptr = pom;
      return iterator;
    }
  }
  iterator.index = 0; //nutna inicializace pro -O2
  iterator.ptr = NULL;
  iterator.htptr = t;
  return iterator;

}
