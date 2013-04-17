/*
 * File:   htable_lookup.c
 * Reseni  IJC-DU2, priklad 2
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 4. dubna 2011
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "htable.h"

/**
 * vyhledaní prvku v tabulce, pri nenalezeni prida zaznam do tabulky
 * @param t ukazatel na tabulku
 * @param key retezce ktery hledame
 * @return ukazatel na polozku tabulky
 */
inline struct htable_listitem* htable_lookup(htable_t* t, char *key) {

  unsigned int index = hash_function(key, t->htable_size);

  for(struct htable_listitem* i = t->uk[index]; i != NULL; i = i->next) {
    if (strcmp(i->key,key) == 0)
      return i;
  }

  struct htable_listitem* item = t->uk[index];
  struct htable_listitem* newitem = malloc(sizeof(struct htable_listitem));
  if (newitem == NULL)
    return NULL;

  newitem->key = malloc((strlen(key)+1) * sizeof(char));
  if (newitem->key == NULL)
    return NULL;
  strcpy(newitem->key, key);
  newitem->next = item;
  t->uk[index] = newitem;
  t->uk[index]->data = 0;
  //htable->uk[index]->next = item;

  return newitem;
}
