ZIP=makefile tail.c io.c hash_function.c htable_begin.c htable_clear.c htable_end.c htable_free.c htable_init.c htable_iter_deref.c htable_iter_eq.c htable_iter_next.c htable_lookup.c wordcount.c io.c htable.h tail2.cc
CC=gcc
CFLAGS=-std=c99 -pedantic -Wall -fPIC -g
OBJ=hash_function.o htable_begin.o htable_clear.o htable_end.o htable_free.o htable_init.o htable_iter_deref.o htable_iter_eq.o htable_iter_next.o htable_lookup.o wordcount.o io.o

all: tail tail2 libhtable.a wordcount libhtable.so wordcount-dynamic 

.PHONY: clean pack wcpp

tail: tail.o
	$(CC) $(CFLAGS) -o tail tail.o
tail.o: tail.c
	$(CC) $(CFLAGS) -c tail.c
tail2: tail2.cc
	g++ -std=c++98 -pedantic -Wall -o tail2 tail2.cc
wordcount: wordcount.o io.o libhtable.a htable.h
	$(CC) $(CFLAGS) -static io.o wordcount.o -L. -lhtable -o wordcount
wordcount-dynamic: wordcount.o io.o libhtable.so htable.h
	$(CC) $(CFLAGS)  -Wl,-rpath,. -L. -lhtable io.o wordcount.o -o wordcount-dynamic
hash_function.o: hash_function.c htable.h
	$(CC) $(CFLAGS) -c hash_function.c
htable_begin.o: htable_begin.c htable.h
	$(CC) $(CFLAGS) -c htable_begin.c
htable_clear.o: htable_clear.c htable.h
	$(CC) $(CFLAGS) -c htable_clear.c
htable_end.o: htable_end.c htable.h
	$(CC) $(CFLAGS) -c htable_end.c
htable_free.o: htable_free.c htable.h
	$(CC) $(CFLAGS) -c htable_free.c
htable_init.o: htable_init.c htable.h
	$(CC) $(CFLAGS) -c htable_init.c
htable_iter_deref.o: htable_iter_deref.c htable.h
	$(CC) $(CFLAGS) -c htable_iter_deref.c
htable_iter_eq.o: htable_iter_eq.c htable.h
	$(CC) $(CFLAGS) -c htable_iter_eq.c
htable_iter_next.o: htable_iter_next.c htable.h
	$(CC) $(CFLAGS) -c htable_iter_next.c
htable_lookup.o: htable_lookup.c htable.h
	$(CC) $(CFLAGS) -c htable_lookup.c
wordcount.o: wordcount.c htable.h
	$(CC) $(CFLAGS) -c wordcount.c
io.o: io.c htable.h
	$(CC) $(CFLAGS) -c io.c
libhtable.a: $(OBJ) htable.h
	ar rcs libhtable.a $(OBJ)
libhtable.so: $(OBJ) htable.h
	$(CC) -shared $(OBJ) -o libhtable.so
clean:
	rm -f $(OBJ) tail.o
	rm -f tail wordcount wordcount-dynamic wordcount2
	rm -f libhtable.a libhtable.so
	rm -f xjanys00.zip
pack: $(ZIP)
	zip -r -q xjanys00.zip $(ZIP)
wcpp: wordcount.cc
	g++ -std=c++98 -pedantic -Wall -o wordcount2 wordcount.cc
