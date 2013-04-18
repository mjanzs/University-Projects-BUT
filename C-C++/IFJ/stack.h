/*
 * Implementace interpretu imperativniho jazyka IFJ2011
 *
 * Autori:
 *  xbedna45 - Bednarik Jan
 *  xblaha22 - Blaha Hynek
 *  xjanys00 - Janys Martin
 *  xmacha48 - Machacek Ondrej
 */

#ifndef STACK_H
#define STACK_H

#include <stdbool.h>
#include "ilist.h"
#include "str.h"

#define STACK_ERROR 1
#define STACK_SUCCESS 0

#define PROG_STACK_SIZE 1024

typedef enum idTypes {
    FUNC,
    BUILT_IN_FUNC,
    NUM_TYPE,
    STR_TYPE,
    BOOL_TYPE,
    NIL_TYPE //NIL je token
} VarType;

typedef union {
    double num;
    string str;
    bool boolean;
} UvariableData;

typedef struct {
    VarType type; //literal type
    UvariableData data;
} Tvariable;

//na zasobniku jsou adresy do inst. pasky(nealokujise/nedealokuji se)
//nebo promenne ktere je nutne predavat hodnotou

typedef union {
    Tvariable* variable;
    iItem* instruction;
} UstackItem;

typedef struct {
    UstackItem* stack;
    unsigned int act; //"base pointer" 
    unsigned int top; //vrchol
    unsigned int allocSize; // velikost alokovane pameti
} Tstack;

int stackInit(Tstack* s);
void stackFree(Tstack* s);

/** stackPrepareMem
 * posune vrchol zasobniku o n a inicialuzuje na NULL
 * pouziva se pri skoku do funkce (n = pocet loc. var)
 */
int stackPrepareMem(Tstack *s, unsigned int n);

/** stackPush
 * vlozi jednu promennou na zasobnik
 * pouziva se k vlozeni paramentru pri volani fce
 */
int stackPush(Tstack* s, Tvariable *v);

/** stacktPusthAddress
 * vlozi jendu adresu 
 * pouziva se pri vlozeni navratove adresy na zasobnik
 */
int stackPushAddress(Tstack* s, iItem *i);
bool stackEmpty(Tstack *s);
Tvariable *stackTopAndPop(Tstack* s);
Tvariable *stackTop(Tstack* s);
void stackPop(Tstack* s);
/** stackGetVal, stackGetAdr
 * vypocita index do pole a vrati jeho obsah od ACT!
 */
Tvariable* stackGetVal(Tstack *s, int i);
iItem* stackGetAdr(Tstack *s);

int stackSetVal(Tstack *s, Tvariable *v, int i);

/** stackDisposeVariables
 * zrusi(uvolni) n pocet promennych na zasobniku
 * pouziva se pri navratu 
 */
void stackDisposeVariables(Tstack* s, int count);

/** stackDisposeAddress
 * polozka = NULL, neuvolnuje nesmi!
 * pouziva se pri navratu po nacteni a po uvolneni promennych protoze se jedna o POP bez dealokace musi byt na vrcholu
 */
void stackDisposeAddress(Tstack* s);
void actToTop(Tstack *s);
int getStackIndex(Tstack* s, int i);

/** toToAct
 * posune to na act
 * a dealokuje pomocny promenny
 * pouziva se po dokonceni vyrazu
 */
void stackTopToAct(Tstack *s);

/** actToTop
 * posune act(BP) na vrchol
 */
void stackActToTop(Tstack *s);

int stackAlignParams(Tstack *s, int n);
void stackPrint(Tstack *s, unsigned int n);
#endif
