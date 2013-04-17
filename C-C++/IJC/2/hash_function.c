/*
 * File:   hash_function.c
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
 * rozptylovaci funkce
 * @param str retezec
 * @param htable_size velikost tabulky
 * @return index
 */
unsigned int hash_function(const char *str, unsigned htable_size) {

  unsigned int h = 0;
  unsigned char *p;

  for(p = (unsigned char*)str; *p != '\0'; p++)
    h = 31*h + *p;

  return h % htable_size;
}