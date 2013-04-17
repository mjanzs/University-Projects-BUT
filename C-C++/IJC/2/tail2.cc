/*
 * File:   tail2.cc
 * Reseni  IJC-DU2, priklad 1 b)
 * Author: Martin Janys, FIT
 *
 * Přeloženo: gcc 4.4.5 (Merlin)
 * Created on 14. dubna 2011
 *
 */

#include <iostream>
#include <fstream>
#include <deque>

using namespace std;

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
  E_RANGE
};

/**
 * stavy programu
 */
enum states {
  normal,
  lastX,
  fromX,
  ERR
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
  "Prilis velke cislo (overflow)\n"
};

/**
 * tisk chyboveho hlaseni
 * @param error
 * @return
 */
int printError(int ECODE)
{
  cerr << "ERROR:" << ECODEMSG[ECODE] << "\n";
  exit (EXIT_FAILURE);
}

/**
 * zpracovani parametru
 * @param argc
 * @param argv
 * @return
 */
TParams getParams (int argc, char** argv) {

    TParams result;

    //result.stream = "stdin";
    result.ecode = E_OK;
    result.state = normal;
    result.lines = DEF_LINES;
    result.input_stdin = true;
 
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

  return result;
}

/**
 * tisk poslednich X radku
 * @param linesCount cislo kolik poslednich radku se bude tisknout
 * @param input
 */
void printLastX(int linesNum, istream &input) {

  deque<string> buffer;

  string pom;

  int index = 0;//, counter = 0;

  while (getline(input, pom)) {
    buffer.push_back(pom);
    if(index >= linesNum)
        buffer.pop_front();
    index++;
  }

  while(!(buffer.empty()))
  {
    cout << buffer.front() << "\n";
    buffer.pop_front();
  }
  return;
}
/**
 * tisk od radku X
 * @param lineNum cislo radku
 * @param input
 */
void printFromX(int lineNum, istream &input) {

  string buffer;

  //char buffer[LINE_CHAR];
  int index = 1;

  while ((getline(input, buffer)) && (index < lineNum-1)) {
    index++;
  }

  while (getline(input, buffer)) {
    cout << buffer << "\n";
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
  istream *input = &cin;
  ifstream file;


  if (param.state == ERR) {
    printError(E_PARAM);
    return (EXIT_FAILURE);
  }

  //infile.open ("test.txt", ifstream::in);
if(!param.input_stdin) {
  file.open(param.stream, ifstream::in);
  if(!file.is_open()) {
    printError(E_OPEN);
    return 1;
  }
  input = &file;
}
  switch(param.state){
    case normal :
      //nerprintf("normal %d - %s", param.lines, param.stream);
      printLastX(param.lines, *input);
    break;
    case fromX :
      //printf("fromX - %s", param.stream);
      printFromX(param.lines, *input);
    break;
    case lastX :
      //printf("lastX - %s", param.stream);
      printLastX(param.lines, *input);
    break;
  }

  file.close();


  return (EXIT_SUCCESS);
}


