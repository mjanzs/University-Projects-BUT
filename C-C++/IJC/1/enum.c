/* 
 * File:   enum.c
 * �e�en�  IJC-D�, p��klad a)
 * Author: Martin Jany�, FIT
 *
 * P�elo�eno: gcc 4.4.5 (Merlin)
 * Created on 17. b�ezna 2011
 * 
 * Pr�ce s v��tov�m typem.
 * Identifikace m�s�ce.
 */

#include <stdlib.h>
#include <stdio.h>
#include <ctype.h>
#include <string.h>
#include "enum.h"
#include "error.h"

#define stringMaxLen 15
#define countM 12

/*
 * Tato funkce tiskne �et�zec odpov�daj�c� zadan� hodnot�
 * v��tov�ho typu �esky ("Led", "�no", "B�e", "Dub" ...).
 */
void PrintMonthShort(enum months d){

  static const char* mesic[] = {
    "ChybnyMesic",
    "Led",
    "�no",
    "B�e",
    "Dub",
    "Kv�",
    "�en",
    "�ec",
    "Srp",
    "Z��",
    "��j",
    "Lis",
    "Pro",
  };

  if (d <= countM)
    printf("%s", mesic[d]);
  else
    Error("PrintMonthShort: Hodnota %d je mimo rozsah\n", d);
}
/*
 * tato funkce tiskne �et�zec odpov�daj�c� zadan� hodnot�
       v��tov�ho typu ("Leden", "�nor", ...).
 */
void PrintMonth(enum months d) {

  static const char* mesic[] = {
    "ChybnyMesic",
    "Leden",
    "�nor",
    "B�ezen",
    "Duben",
    "Kv�ten",
    "�erven",
    "�ervenec",
    "Srpen",
    "Z���",
    "��jen",
    "Listopad",
    "Prosinec",
  };

  if (d <= countM)
    printf("%s", mesic[d]);
  else
    Error("PrintMonth: Hodnota %d je mimo rozsah\n", d);
}
/*
 * funkce p�esko�� v�echny b�l� znaky (isspace),
       potom p�e�te slovo (posloupnost znak� z mno�iny definovan� makrem
       isalpha, zapn�te si lokalizaci),
       potom provede p�evod ("Led", "led", "Leden", "LEden", ... na Leden)
       a vr�t� v�sledek. Pokud nejde o identifikaci m�s�ce, vrac� nulu (ChybnyMesic).
       Funkce bude "case insensitive" a rozpozn� v�echny varianty vypisovan�
       funkc� strftime pro form�t "%b" a "%B" (p�edpokl�d�me �eskou
       lokalizaci:  LC_TIME=cs_CZ date +"%b" -d now+1month ).
       Nav�c rozpozn� a p�evede varianty zapsan� bez diakritiky - "cesky".
 �*/
enum months ReadMonth(void){

  int c, i;
  char mesic[stringMaxLen];

    static const char* mesicLong[] = {"ChybnyMesic","leden","�nor","b�ezen",
      "duben","kv�ten","�erven","�ervenec","srpen","z���","��jen","listopad",
      "prosinec",
    };
    static const char* mesicLongASCII[] = {"ChybnyMesic","leden","unor","brezen",
      "duben","kveten","cerven","cervenec","srpen","zari","rijen","listopad",
      "prosinec",
    };

    static const char* mesicShort[] = {"ChybnyMesic","led","�no","b�e",
      "dub","kv�","�en","�ec","srp","z��","��j","lis", "pro",
    };
    static const char* mesicShortASCII[] = {"ChybnyMesic","led","uno","bre",
      "dub","kve","cen","cec","srp","zar","rij","lis","pro",
    };
    
    i = 0;
    while ((c = getchar()) && (c != '\n') && i < stringMaxLen-1){
      if (isspace(c)) {
        if (i == 0)
          continue;
        else 
          break;
      }
      if (isalpha(c)) {
        mesic[i] = tolower(c);
        //printf("** %c **\n", mesic[i]);
        i++;
      }
      else {
        break;
      }
    }
  mesic[i+1] = 0;
    
  for(i = 0; i <= countM; i++){
    if(strcoll(mesic, mesicLong[i]) == 0) return i;
    if(strcmp(mesic, mesicLongASCII[i]) == 0) return i;
    if(strcoll(mesic, mesicShort[i]) == 0) return i;
    if(strcmp(mesic, mesicShortASCII[i]) == 0) return i;
  }
    return 0; //cili chyba
}
