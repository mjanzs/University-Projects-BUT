/* 
 * File:   error.c
 * Øešení IJC-DÚ, pøíklad a),b)
 * Author: Martin Janyš, FIT
 *
 * Pøeloženo: gcc 4.4.5 (Merlin)
 * Created on 17. bøezna 2011
 * 
 * Chybové hlášení.
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