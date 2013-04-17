/*
 * File:   tail.c
 * Reseni  IJC-DU2, priklad 1 a)
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 8. dubna 2011
 *
 */

#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>
#include <string.h>
#include <stdbool.h>
#include <errno.h>

#define DEF_LINES 10
#define LINE_CHAR (1024 + 2) //2-> '\n' and 0

/**
 * chybove stavy
 */
enum ecodes {
  E_OK,
  E_PARAM,
  E_OPEN,
  E_CLOSE,
  E_OVERFLOW,
  E_RANGE,
  E_MEM
};

/**
 * stavy programu
 */
enum states {
  normal,
  lastX,
  fromX,
  ERR,
};

/**
 * parametry programu
 */
typedef struct params {
  char* stream;
  int state;
  int ecode;
  unsigned long lines;
  bool input_stdin;
} TParams;
/**
 * retezce pro tisk chyby
 */
const char *ECODEMSG[] =
{	
  "OK\n",
  "Chybne parametry\n",
  "Soubor se nepodarilo otevrit.\n",
  "Soubor se podarilo se uzav.\n",
  "Delka radku prekrocila limit.\n",
  "Prilis velke cislo (overflow)\n",
  "Nedostatek pameti\n"
};

/**
 * tisk chyboveho hlaseni
 * @param error
 * @return
 */
void printError(int ECODE)
{
  fprintf(stderr, "ERROR: %s\n", ECODEMSG[ECODE]);
}

/**
 * zpracovani parametru
 * @param argc
 * @param argv
 * @return
 */
TParams getParams (int argc, char** argv) {
  TParams result =
  {
    .stream = "stdin",
    .ecode = E_OK,
    .state = normal,
    .lines = DEF_LINES,
    .input_stdin = true,
  };
  char* endptr;

  if (argc == 2) {
    result.stream = argv[1];
    result.input_stdin = false;
  }
  else if ((argc == 3 || argc == 4) && ((argv[1][0] == '-') && (argv[1][1] == 'n'))) {
    if (argv[2][0] == '+')
      result.state = fromX;
    else
      result.state = lastX;

    result.lines = strtoul(argv[2], &endptr, 10);
    if (errno == ERANGE)
      printError(E_RANGE);
    if ((*endptr) != '\0')
      printError(E_PARAM);
    
    if (argc == 4) {
      result.input_stdin = false;
      result.stream = argv[3];
    }
  }
  if(result.lines < 0)
    result.lines = result.lines * -1;
  return result;
}

/**
 * tisk poslednich X radku
 * @param linesCount cislo kolik poslednich radku se bude tisknout
 * @param input
 */
void printLastX(int linesNum, FILE* input) {

  bool error_printed = false;
  int index = 0, counter = 0;
  char* buffer [linesNum];
  for (unsigned long i = 0; i < linesNum; i++) {
    buffer [i] = malloc(LINE_CHAR * sizeof(char));
    if (buffer[i] == NULL){
      if (input != stdin)
        if (fclose(input) == EOF)
	  printError(E_CLOSE);
      printError(E_MEM);
    for(unsigned long ii = 0; ii < i; i++)
      free(buffer[i]);
    }
  }

  while (fgets(buffer[index], LINE_CHAR, input) != NULL) {
    counter++;
    //printf("-- %d -- \n", strlen(buffer[index]));
    if ((strstr(buffer[index], "\n") == NULL) && error_printed != true){ // "\n\0"
      printError(E_OVERFLOW);
      error_printed = true;
    }
    index = counter % linesNum;
  }  
  for(int i = 0; i < linesNum; i++) {
    fputs(buffer[(i + counter) % linesNum], stdout);
  }
  for (int i = 0; i < linesNum; i++) {
    free(buffer [i]);;
  }
  return;
}
/**
 * tisk od radku X
 * @param lineNum cislo radku
 * @param input
 */
void printFromX(int lineNum, FILE* input) {

  char buffer[LINE_CHAR];
  int index = 1;

  while ((fgets(buffer, LINE_CHAR, input) != NULL) && (index < lineNum-1)) {
    if (strstr(buffer, "\n") == NULL) // "\n\0"
      printError(E_OVERFLOW);
    index++;
  }

  while (/*setbuf(input, _IOFBF), */fgets(buffer, LINE_CHAR, input) != NULL) {
    fputs(buffer, stdout);
  }
}
/**
 *
 * @param argc
 * @param argv
 * @return
 */
int main(int argc, char** argv) {

  TParams param = getParams(argc, argv);
  FILE *input;
  
  if (param.state == ERR) {
    printError(E_PARAM);
    return (EXIT_FAILURE);
  }

  if (!param.input_stdin) {
    input = fopen(param.stream, "r");
    if (input == NULL)
      printError(E_OPEN);
   }
  else {
    input = stdin;
  }

  switch(param.state){
    case normal :
      //nerprintf("normal %d - %s", param.lines, param.stream);
      printLastX(param.lines, input);
    break;
    case fromX : 
      //printf("fromX - %s", param.stream);
      printFromX(param.lines, input);
    break;
    case lastX : 
      //printf("lastX - %s", param.stream);
      printLastX(param.lines, input);
    break;
  }

  if (!param.input_stdin)
    if (fclose(input) == EOF)
	printError(E_CLOSE);
  
  return (EXIT_SUCCESS);
}
