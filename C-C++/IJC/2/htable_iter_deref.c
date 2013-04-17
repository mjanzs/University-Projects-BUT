/*
 * File:   htable_iter_deref.c
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
 * dereference iteratoru
 * @param i
 * @return ukazatel na polozku
 */
inline struct htable_listitem* htable_iter_deref(struct htable_iterator iter) {

  struct htable_listitem* listitem;

  listitem = iter.ptr;

  return listitem;
}