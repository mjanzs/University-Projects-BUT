CC=gcc
CFLAGS=-std=gnu99 -Wall -Wextra -pedantic -Werror

.PHONY:clean pack

all: barbers

barbers: barbers.c
	$(CC) $(CFLAGS) -lrt barbers.c -o barbers 
clean:
	rm -f xjanys00.tip
	rm -f barbers
pack:
	zip -r -q xjanys00.zip barbers.c makefile
