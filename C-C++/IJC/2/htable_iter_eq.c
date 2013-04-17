/*
 * File:   htable_iter_eq.c
 * Reseni  IJC-DU2, priklad 2
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 4. dubna 2011
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>
#include "htable.h"

/**
 * porovnani iteratoru
 * @param i1 iterator
 * @param i2 iterator
 * @return true/false
 */
inline bool htable_iter_eq(struct htable_iterator iter1, struct htable_iterator iter2) {
/*
if(iter1.ptr == iter2.ptr) return 1;  // porovnani iteratoru
  else return 0;
*/
  
  if (iter1.htptr != iter2.htptr)
    return false;
  else if (iter1.index != iter2.index)
    return false;
  else {
    if (strcmp(iter1.ptr->key, iter2.ptr->key) == 0)
      return true;
    else
      return false;
  }

}
