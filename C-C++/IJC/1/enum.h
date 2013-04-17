/* 
 * File:   enum.h
 * Øešení  IJC-DÚ, pøíklad a)
 * Author: Martin Janyš, FIT
 *
 * Pøeloženo: gcc 4.4.5 (Merlin)
 * Created on 17. bøezna 2011
 * 
 */

#ifndef ENUM_H
#define	ENUM_H

typedef enum months {
    ChybnyMesic = 0,
    Leden = 1,
    Unor,
    Brezen,
    Duben,
    Kveten,
    Cerven,
    Cervenec,
    Srpen,
    Zari,
    Rijen,
    Listopad,
    Prosinec
 } mounths;

enum months;

void PrintMonthShort(enum months d);

void PrintMonth(enum months d);

enum months ReadMonth(void);

#endif	/* ENUM_H */

