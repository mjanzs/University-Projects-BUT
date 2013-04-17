/*
 * File:   htable.h
 * Reseni  IJC-DU2, priklad 2
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 4. dubna 2011
 *
 * Hlavickový soubor pro praci s hashovaci tabulkou
 */

#include <stdbool.h>

#ifndef HTABLE_H
#define	HTABLE_H
/**
 * typ hashovaci tabulka
 */
typedef struct {
    unsigned int htable_size;
    struct htable_listitem **uk;
} htable_t;
/**
 * key .... ukazatel na dynamicky alokovaný řetězec
 * data ... počet výskytů
 * next ... ukazatel na další záznam
 */
typedef struct htable_listitem htable_listitem;
struct htable_listitem {
    char* key;
    int data;
    htable_listitem* next; 
};
/**
 * htptr ... ukazatel na tabulku
 * index ... odpovídá pozici iterátoru v poli (pozor při porovnávání)
 * ptr ..... ukazatel na položku nebo NULL
 */
struct htable_iterator {
    htable_t* htptr; //ukazatel na tabulku
    int index; //odpovídá pozici iterátoru v poli
    htable_listitem* ptr; //ukazatel na položku nebo NULL
};
/**
 * hashovaci funkce
 * @param str retezec
 * @param htable_size velikost pole
 * @return UK-index tabulky
 */
unsigned int hash_function(const char *str, unsigned htable_size);

/**
 * cte slovo
 * @param s retezec
 * @param max maximalni pocet znaku
 * @param f vstup
 * @return delka retezce, EOF == 0
 */
int fgetword(char *s, int max, FILE *f);

/**
 * vytvoření a inicializaci tabulky
 * @param htable_size velikost tabulky
 * @return ukazatel na tabulku
 */
htable_t* htable_init(unsigned htable_size);

/**
 * vyhledaní prvku v tabulce, pri nenalezeni prida zaznam do tabulky
 * @param t ukazatel na tabulku
 * @param key retezce ktery hledame
 * @return ukazatel na polozku tabulky
 */
struct htable_listitem* htable_lookup(htable_t *t, char *key);

/**
 * nalezne prvni iterator v tabulce
 * @param t ukazatel na tabulku
 * @return  iterator
 */
struct htable_iterator htable_begin(htable_t *t);

/**
 * nalezne posledni iterator v tabulce
 * @param t ukazatel na tabulku
 * @return  iterator
 */
struct htable_iterator htable_end(htable_t *t);

/**
 * posun iteratoru v tabulce
 * @param i iterator
 * @return iterator nasledujiciho
 */
struct htable_iterator htable_iter_next(struct htable_iterator i);

/**
 * porovnani iteratoru
 * @param i1 iterator
 * @param i2 iterator
 * @return true/false
 */
bool htable_iter_eq(struct htable_iterator i1, struct htable_iterator i2);

/**
 * dereference iteratoru
 * @param i
 * @return ukazatel na polozku
 */
struct htable_listitem* htable_iter_deref(struct htable_iterator i);

/**
 * maze zaznamy tabulky
 * @param t ukazatel na tabulku
 */
void htable_clear(htable_t* t);

/**
 * uvolnuje tabulku
 * @param t ukazatel na tabulku
 */
void htable_free(htable_t* t);

/**
 *
 * @param htable
 * @param htable_size_new
 * @return
 */
htable_t* htable_resize(htable_t* htable, unsigned htable_size_new);

#endif	/* HTABLE_H */

