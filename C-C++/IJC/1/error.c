/* 
 * File:   error.c
 * �e�en� IJC-D�, p��klad a),b)
 * Author: Martin Jany�, FIT
 *
 * P�elo�eno: gcc 4.4.5 (Merlin)
 * Created on 17. b�ezna 2011
 * 
 * Chybov� hl�en�.
 */


#include <stdlib.h>
#include <stdio.h>
#include <stdarg.h>
#include "error.h"

void Error (const char *fmt, ...) {

  va_list args;
  va_start (args, fmt);

  vfprintf (stderr, fmt, args);

  va_end (args);

  exit(1);
}