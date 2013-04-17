/*
 * File:   htable_iter_next.c
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
 * posun iteratoru v tabulce
 * @param i iterator
 * @return iterator nasledujiciho
 */
inline struct htable_iterator htable_iter_next(struct htable_iterator iter) {

  int i;
  struct htable_iterator next;
  next.htptr = iter.htptr; //inicializace -O2
  next.index = 0;
  next.htptr = iter.htptr;

  if(iter.ptr->next != NULL) {
    next.index = iter.index;
    next.ptr = iter.ptr->next;
    return next;
  }
  else {
    i = iter.index+1;
    if(i == (int)iter.htptr->htable_size) {
      next.ptr = NULL;
      next.index = iter.index;
      return next;
    }
    for(/*int i = (iter.index+1)*/; i < (int)iter.htptr->htable_size; i++) {
      if(iter.htptr->uk[i] != NULL) {
        next.ptr = iter.htptr->uk[i];
        next.index = i;
        return next;
      }
    }
  }
     
  return next;
}