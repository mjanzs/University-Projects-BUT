/*
 * File:   htable_free.c
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
 * uvolnuje tabulku
 * @param t ukazatel na tabulku
 */
void htable_free(htable_t* t) {
  htable_clear(t);
  free(t->uk);
  free(t);
}