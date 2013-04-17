
CC=gcc
obj=error.o prvocisla.o prvocisla-inline.o enum.o enumtest.o
CFLAGS=-std=c99 -pedantic -Wall -Wextra -W -g -O2 
INLINE=-DUSE_INLINE

all : prvocisla prvocisla-inline enumtest

prvocisla : prvocisla.o error.o
	$(CC) $(CFLAGS) -o prvocisla prvocisla.o error.o

prvocisla-inline : prvocisla-inline.o error.o
	$(CC) $(CFLAGS) $(INLINE) -o prvocisla-inline prvocisla-inline.o error.o

enumtest : enumtest.o enum.o error.o
	$(CC) $(CFLAGS) -o enumtest enumtest.o enum.o error.o

prvocisla-inline.o : prvocisla.c
	$(CC) $(CFLAGS) $(INLINE) -o prvocisla-inline.o -c prvocisla.c

prvocisla.o : prvocisla.c
	$(CC) $(CFLAGS) -c prvocisla.c

enumtest.o: enumtest.c enum.h
	$(CC) $(CFLAGS) -c enumtest.c

enum.o: enum.c enum.h
	$(CC) $(CFLAGS) -c enum.c

error.o: error.c error.h
	$(CC) $(CFLAGS) -c error.c

#zamerne nepouzivano
clean: 
	rm -f $(obj)

