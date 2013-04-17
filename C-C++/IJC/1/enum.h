/* 
 * File:   enum.h
 * �e�en�  IJC-D�, p��klad a)
 * Author: Martin Jany�, FIT
 *
 * P�elo�eno: gcc 4.4.5 (Merlin)
 * Created on 17. b�ezna 2011
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

