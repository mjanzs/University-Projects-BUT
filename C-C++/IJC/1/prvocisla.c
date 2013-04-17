/* 
 * File:   main.c
 * Author: Martin
 *
 * Created on 24. únor 2011, 19:12
 */

#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <limits.h>
#include "error.h"

#define N 90000000
#define NUM 20

// pocet bitu v unsigned long
#define BITSLONG (CHAR_BIT * sizeof(unsigned long))

// vypocita kolik longu bude potreba
#define LONGCOUNT(bits)	((bits) / BITSLONG + ((bits) % BITSLONG != 0))

// index longu
#define I_LONG(index) ((index) / BITSLONG)

// index v ramci longu
#define OFF_LONG(index) ((index) % BITSLONG)
/* Definujte makra pro pole bitů:
   BitArray(jmeno_pole,velikost)
   definuje a nuluje pole (POZOR: MUSÍ _INICIALIZOVAT_ bez ohledu
   na to, zda je pole statické nebo automatické/lokální!*/
// definuje a nuluje pole, velikost tj pocet bitu
#define BitArray(jmeno_pole, velikost) size_t sizeofPole = (velikost); \
	unsigned long jmeno_pole [LONGCOUNT(velikost)] = {0};


/******************************************************************************/
/*****************************INLINE FUNKCE************************************/
/******************************************************************************/
#ifdef USE_INLINE

#	define SetBit(jmeno_pole, index, vyraz) \
    inLineSetBit(jmeno_pole, index, vyraz, sizeofPole)
#	define GetBit(jmeno_pole, index) \
    inLineGetBit(jmeno_pole, index, sizeofPole)

int inLineGetBit(unsigned long* pole, unsigned long index, size_t sizeofPole);
void inLineSetBit(unsigned long* pole, unsigned long index, int vyraz, size_t sizeofPole);
/******************************************************************************/
/*******************************Macra******************************************/
/******************************************************************************/
#else
/* SetBit(jmeno_pole,index,výraz)
   nastaví zadaný bit v poli na hodnotu zadanou výrazem
   (nulový výraz --> bit 0, nenulový výraz --> bit 1)
   Př: SetBit(p,20,1);
 */
// nastavi zadany bit
#	define SetBit(jmeno_pole, index, vyraz) \
  if ((index) >= sizeofPole) \
    Error("Index %ld mimo rozsah 0..%ld", (long)(index), (long)(sizeofPole)); \
  jmeno_pole[I_LONG(index)] = (((vyraz) == 1 ? \
  (jmeno_pole[I_LONG(index)] | (1 << OFF_LONG(index))) :\
  (jmeno_pole[I_LONG(index)] & (~(1 << OFF_LONG(index))))));
/* GetBit(jmeno_pole,index)
   získá hodnotu zadaného bitu, vrací hodnotu 0 nebo 1
   Př: if(GetBit(p,i)==1) printf("1");
       if(!GetBit(p,i))   printf("0");
 */
// precte zadany bit
#	define GetBit(jmeno_pole, index) \
  ((index) >= sizeofPole) ? \
  (Error("Index %ld mimo rozsah 0..%ld", (long)(index), (long)(sizeofPole)), 0) : \
  (( jmeno_pole[I_LONG(index)] & (1 << OFF_LONG(index))) != 0)

#endif
/************************************* INLINE ***************************************/
inline void inLineSetBit(unsigned long* pole, unsigned long index, int vyraz, size_t sizeofPole){

  if ((index) >= sizeofPole)
    Error("Index %ld mimo rozsah 0..%ld", index, sizeofPole);
  if (vyraz)
    pole[I_LONG(index)] |= (1 << OFF_LONG(index));
  else
    pole[I_LONG(index)] &= (~(1 << OFF_LONG(index)));

}

inline int inLineGetBit(unsigned long* pole, unsigned long index, size_t sizeofPole) {

  if (index >= sizeofPole)
    Error("Index %ld mimo rozsah 0..%ld", (long)(index), (long)(sizeofPole));

  return ((pole[I_LONG(index)] & ((1 << OFF_LONG(index)))) != 0);
}
/*
 * 
 */
int main(void) {

  unsigned long i, j;
  unsigned long backshift = N-1;
  BitArray(pole, N);
//inicializovano na 0
  for (i = 2; i <= sqrt(N); i++) {
    if(GetBit(pole, i) == 0) {
      j = 2*i;

      while (j <= N-1 /*&& !(GetBit(pole, i))*/) { // zakomentovan� paradoxne zpomalovalo
        SetBit(pole, j, 1);
        j += i;
      }
    }
  }
  
  i = 1;
  while (i <= NUM){
    if (GetBit(pole, backshift) == 0)
      i++;
    backshift--;
  }


  for (i = backshift; i < N; i++) {
    if (GetBit(pole, i) == 0)
      printf("%ld\n", i);
  }
          
  return (EXIT_SUCCESS);
}


