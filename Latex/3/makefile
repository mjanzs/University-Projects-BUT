NAME=proj3
TRASH=$(NAME).aux $(NAME).log $(NAME).dvi $(NAME).ps

.PHONY: pack clean

all:
	latex $(NAME).tex
	latex $(NAME).tex
	dvips -t a4 $(NAME).dvi
	ps2pdf $(NAME).ps

pack: $(NAME).tex makefile
	zip -r -q xjanys00-fit makefile $(NAME).tex etiopan.eps oniisan.eps oniisan2.eps
clean: $(TRASH)
	rm -f $(TRASH)
