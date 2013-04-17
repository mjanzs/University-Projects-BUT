/*
 * File:   wordcount.c
 * Reseni  IJC-DU2, priklad 2
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 4. dubna 2011
 *
 * Pocita cetnost vyskytu slov, implementace hashovaci tabulky
 */
#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include "htable.h"

/* Hashovaci fce zavisi na delce slova
 * Velikost htable a efektivita je spojena s pouzitim (s pocetm slov)
 * tuto hodnotu jsem experimentalne stanovil jako stredni mezi hodne velkym a 
   malym pocetem slov
 * kriteriem byla casova narocnost
 * vhodne je take zvolit prvocislo
 */
#define HTABLE_SIZE 10979
#define MAXSTRLEN 256 //255+\0

//unsigned long counter = 0;

void ErrorMem(htable_t *h) {
  fprintf(stderr, "Error: Nedostek pameti\n");
  htable_free(h);
  exit(1);
}

int main() {

  char str[MAXSTRLEN] = "";
  FILE* input = stdin;
  htable_t* htable;//, *htable_new;
  struct htable_listitem* listitem;

  htable = htable_init(HTABLE_SIZE);
  if(htable == NULL)
    ErrorMem(htable);

  while (fgetword(str, MAXSTRLEN, input)){
    listitem = htable_lookup(htable, str);
    if (listitem == NULL)
      ErrorMem(htable);
    listitem->data++;
 }

  struct htable_iterator iter_begin, iter_end;

  iter_begin = htable_begin(htable);
  if (iter_begin.ptr == NULL)
    return (EXIT_SUCCESS); //prazdna tabulka
  iter_end = htable_end(htable);

  for(/*struct htable_iterator i = htable_begin(htable)*/;\
          (htable_iter_eq(iter_begin, iter_end) != true);\
          iter_begin = htable_iter_next(iter_begin)) {
    printf("%s\t%i\n", htable_iter_deref(iter_begin)->key, htable_iter_deref(iter_begin)->data);
  }
  printf("%s\t%i\n", htable_iter_deref(iter_end)->key, htable_iter_deref(iter_end)->data);
  
  htable_free(htable);

  return (EXIT_SUCCESS);
}
