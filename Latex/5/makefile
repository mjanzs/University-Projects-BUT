NAME=proj5
TRASH=$(NAME).aux $(NAME).log $(NAME).dvi $(NAME).ps

.PHONY: pack clean

all:
	latex $(NAME).tex
	latex $(NAME).tex
	dvips -t a4 $(NAME).dvi
	ps2pdf $(NAME).ps

pack: $(NAME).tex makefile
	zip -r -q xjanys00-fit makefile $(NAME).tex hriste.eps PPRfyma2.sty
clean: 
	rm -f $(TRASH)
