/* 
 * File:   enum.c
 * Øešení  IJC-DÚ, pøíklad a)
 * Author: Martin Janyš, FIT
 *
 * Pøeloženo: gcc 4.4.5 (Merlin)
 * Created on 17. bøezna 2011
 * 
 * Práce s výètovým typem.
 * Identifikace mìsíce.
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
 * Tato funkce tiskne øetìzec odpovídající zadané hodnotì
 * výètového typu èesky ("Led", "Úno", "Bøe", "Dub" ...).
 */
void PrintMonthShort(enum months d){

  static const char* mesic[] = {
    "ChybnyMesic",
    "Led",
    "Úno",
    "Bøe",
    "Dub",
    "Kvì",
    "Èen",
    "Èec",
    "Srp",
    "Záø",
    "Øíj",
    "Lis",
    "Pro",
  };

  if (d <= countM)
    printf("%s", mesic[d]);
  else
    Error("PrintMonthShort: Hodnota %d je mimo rozsah\n", d);
}
/*
 * tato funkce tiskne øetìzec odpovídající zadané hodnotì
       výètového typu ("Leden", "Únor", ...).
 */
void PrintMonth(enum months d) {

  static const char* mesic[] = {
    "ChybnyMesic",
    "Leden",
    "Únor",
    "Bøezen",
    "Duben",
    "Kvìten",
    "Èerven",
    "Èervenec",
    "Srpen",
    "Záøí",
    "Øíjen",
    "Listopad",
    "Prosinec",
  };

  if (d <= countM)
    printf("%s", mesic[d]);
  else
    Error("PrintMonth: Hodnota %d je mimo rozsah\n", d);
}
/*
 * funkce pøeskoèí v¹echny bílé znaky (isspace),
       potom pøeète slovo (posloupnost znakù z mno¾iny definované makrem
       isalpha, zapnìte si lokalizaci),
       potom provede pøevod ("Led", "led", "Leden", "LEden", ... na Leden)
       a vrátí výsledek. Pokud nejde o identifikaci mìsíce, vrací nulu (ChybnyMesic).
       Funkce bude "case insensitive" a rozpozná v¹echny varianty vypisované
       funkcí strftime pro formát "%b" a "%B" (pøedpokládáme èeskou
       lokalizaci:  LC_TIME=cs_CZ date +"%b" -d now+1month ).
       Navíc rozpozná a pøevede varianty zapsané bez diakritiky - "cesky".
 ¨*/
enum months ReadMonth(void){

  int c, i;
  char mesic[stringMaxLen];

    static const char* mesicLong[] = {"ChybnyMesic","leden","únor","bøezen",
      "duben","kvìten","èerven","èervenec","srpen","záøí","øíjen","listopad",
      "prosinec",
    };
    static const char* mesicLongASCII[] = {"ChybnyMesic","leden","unor","brezen",
      "duben","kveten","cerven","cervenec","srpen","zari","rijen","listopad",
      "prosinec",
    };

    static const char* mesicShort[] = {"ChybnyMesic","led","úno","bøe",
      "dub","kvì","èen","èec","srp","záø","øíj","lis", "pro",
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
