NAME=proj4

all: pdf
.PHONY: clean pack
pdf: $(NAME).tex
	cslatex $(NAME).tex
	bibtex $(NAME).aux
	cslatex $(NAME).tex
	cslatex $(NAME).tex
	dvips -t a4 $(NAME).dvi
	ps2pdf $(NAME).ps

clean:
	rm -f *.aux
	rm -f *.dvi
	rm -f *.pdf
	rm -f *.log
	rm -f *.bbl
	rm -f *.bbg
	rm -f *.blg
	rm -f *.ps
	rm -f xjanys00-fit.zip
pack:
	zip -r -q xjanys00-fit makefile $(NAME).tex bib1.bib czechiso.bst

