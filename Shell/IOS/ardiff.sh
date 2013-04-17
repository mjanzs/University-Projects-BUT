#!/bin/sh

#Marin Jany¹, xjanys00, IOS 1. projekt A

help="ardiff vypisuje zmeny archivu, vytvari rozdilovy archiv nebo aplikuje rozdilovy archiv na zdrojovy archiv.
Pouziti: ardiff [volby] archiv1 archiv2
Volby:
  -o SOUBOR  Pokud je cilem skriptu vytvorit archiv, bude vytvoren do souboru
             se jmenem SOUBOR (plati pro -c a -p).
  -l         Vypis seznamu souboru, ktere se v zadanych archivech lisi.
  -c         Vytvoreni rozdiloveho archivu.
  -p         Aplikace rozdiloveho archivu (argument archiv2) na zdrojovy archiv
             (argument archiv1).
  -r         Prepnuti do reverzniho rezimu (plati pro -p).\n"
############################################################################
# jestlize existuje tmp slozka smaze ji
cleanup()
{
if test -d $mytmp;then
rm -r $mytmp
fi
exit 1
}
############################################################################
# rozbaluje archivy do slozky /tmp/$mytmp/a /tmp/$mytmp/b
unpack()
{
files="a b"
index=1

for i in $files; do
# priprava promennych pro praci
  pom=\$arch$index
  current=`eval echo "$pom"`
  file=`echo "$current" | sed -r 's:.*/(.*):\1:'`
  type=`file "$current" | cut -d ':' -f 2 | sed -r 's:.*(bzip2|Zip|ZIP|gzip|tar).*:\1:'`
# vytvoreni cesty se kterou budem pracovat
  if test -z `echo $current | grep ^/`; then
    filepath="$workdir/$current"
  else
    filepath="$current"
  fi
  mkdir $mytmp/$i
  cp "$filepath" "$mytmp/$i" 2>/dev/null
#overeni existence archivu
  if [ "$?" -eq 1 ]; then
    echo "Chyba: Vstupni soubor neexistuje" >&2
    cleanup
  fi 
  cd $mytmp/$i

  case $type in
	 bzip2)	bzip2 -cd "$file" | tar -xf -
		rm -r "$file";;
	 Zip|ZIP)
		unzip -q -d $mytmp/$i "$file"
		rm "$file";;
	 gzip)	gzip -d "$file"
		pom=`ls`
		tar -xf "$pom"
		rm $pom;;
	 tar)	tar -xf "$file" 
		rm "$file";;
	*) echo "Chyba: Vstupni soubor neni podporovany archiv." >&2
		cleanup;;
  esac
  index=`expr $index + 1`
  cd $workdir
done
}
###########################################################################
# bali archiv - slozku /tmp/$mytmp/c
pack()
{
# dekompozice nazvu
file=`echo $soubor | sed -r 's:.*/(,*):\1:'` 	# nazev
type=`echo $file | sed 's/[^.]*//'` 		# koncovka
filename=`echo $file | sed 's/\..*//'`		# nazev bez koncovky
# priprava cesty
if test -z `echo $soubor | grep ^/`;then
  filepath="$workdir/$soubor"
else
  filepath=$soubor
fi

cd $mytmp
# odmazani prazdnych adresaru
deleteEmptyDir c
cd c

case $type in
	.zip | .ZIP)	zip -r -q "$file" * ;;
	.tar)		tar -cf "$file" * ;;
	.tgz | .tar.gz)	tar -cf "$filename.tar" *
			gzip "$filename.tar"
			if [ $type = .tgz ];then
			mv "$filename.tar.gz" "$filename.tgz"
			fi ;;
	.tar.bz2)	tar -cf "$filename.tar" *
			bzip2 "$filename.tar" ;;
	*) echo "Nepodporovany archiv." >&2 
	   cleanup;;
  esac
cd $workdir
# nakopirovani do pracovniho adresare
cp "$mytmp/c/$file" "$filepath" 2>/dev/null || cp "$mytmp/$file" "$filepath"
}	
###########################################################################
# maze prazdne slozky (arg1)
deleteEmptyDir(){

find $1 -type d | sort -r | while read -r i; do
  ls -l "$i" | grep -q 'total ' && rmdir "$i" 2>/dev/null
done
}
###########################################################################
# param -l vypis rozdilu
list()
{
cd $mytmp
# vypsani vsech adresaru v obou archivech
find a/* | sed -r 's:a\/::' > listA
find b/* | sed -r 's:b\/::' > listB
sort -u listA listB > listUniq
cat listUniq | while read -r i; do
# pripad soubor(symlink) - soubor(symlink) # -f ma pro symlink i soubor stejny return
if [ -f "a/$i" -a -f "b/$i" ]; then
  cmp -s "a/$i" "b/$i"	
  if [ $? -eq 1 ]; then
    echo "$i" >> list
  fi
fi
# soubor - slozka -> vypis obsahu slozky
if [ -f "a/$i" -a -d "b/$i" ]; then
  find "b/$i" | sed 's/b\///' >> list
fi 
# slozka - soubor -> -- " " --
if [ -d "a/$i" -a -f "b/$i" ]; then
  find "a/$i" | sed 's/a\///' >> list
fi
# jeden z adresaru neexistuje
if [ ! -e "a/$i" -o ! -e "b/$i" ]; then
  echo "$i" >> list
fi
done

sort -u list > LIST

cd $workdir

}
###########################################################################
# vytvoreni rozdiloveho archivu
createDiff()
{
# zjisteni rozdilu
list

cd $mytmp

cat LIST | while read -r i; do
# timto krokem vyfiltrujem vsechny neprazdne adresare
  pom=`echo "$i" | grep / | sed -r 's:(.*)/.*:\1:'`
  mkdir -p "c/$pom"
# soubor - soubor
  if [ -f "a/$i" -a -f "b/$i" ]; then
    diff -au "a/$i" "b/$i" > "c/$i.patch"
# slozka - soubor -> objekt, ktery vadi v "difovani" se presouva a do slozky se zanoruje
  elif [ -d "a/$i" -a -f "b/$i" ]; then
    tomove=`mktemp -d a/$i-XXXXX`
    rmdir $tomove && mv "a/$i" "$tomove"
    diff -auN "a/$i" "b/$i" > "c/$i.patch"
    mv "$tomove" "a/$i"

    tomove=`mktemp -d b/$i-XXXXX`
    rmdir $tomove && mv "b/$i" "$tomove"
    echo "`find a/"$i"/*| sed 's/a\///'`" | while read -r ii; do
      pom=`echo "$ii" | grep / | sed -r 's:(.*)/(.*):\1:'`
      mkdir -p "c/$pom"
      diff -auN "a/$ii" "b/$ii" > "c/$ii.patch"
    done
    mv "$tomove" "b/$i"
# soubor - slozka -> ...
  elif [ -f "a/$i" -a -d "b/$i" ]; then
    tomove=`mktemp -d b/$i-XXXXX`
    rmdir $tomove && mv "b/$i" "$tomove";
    diff -auN "a/$i" "b/$i" > "c/$i.patch";
    mv -f "$tomove" "b/$i";

    tomove=`mktemp -d b/$i-XXXXX`
    rmdir $tomove && mv "a/$i" "$tomove"
    echo "`find b/"$i"/* | sed 's/b\///'`" | while read -r ii; do
      pom=`echo $ii | grep / | sed -r 's:(.*)/(.*):\1:'`
      mkdir -p "c/$pom"
      diff -auN "a/$ii" "b/$ii" > "c/$ii.patch"
    done
    mv "$tomove" "a/$i"
# posledni pripad - jeden ze souboru neexistuje a zaroven na nej prozatim nebyl vytvoren patch
  elif [ \( \( \( ! -e "a/$i" -a -e "b/$i" \) -o \( -e "a/$i" -a ! -e "b/$i" \) \) \
	  -a ! -e "c/$i.patch" \) -a \( ! -d "a/$i" -a ! -d "b/$i" \) ]; then
    diff -auN "a/$i" "b/$i" > "c/$i.patch" 
  fi
done

cd $workdir
}
################################################################
# aplikace rozdiloveho archivu
applyDiff()
{
# rozdilovy B na A
cd $mytmp
# vypis a uprava vseho co obsahuje patch archiv
echo "`find b/* | grep .patch | sed 's/b\///'`" | while read -r i; do
# vytvareni slozek  
  pom=`echo "$i" | grep / | sed -r 's:(.*)/.*:\1:'`
  mkdir -p "a/$pom"
# vytvareni nazvu vystupu
  pom2=`echo "$i" | sed 's/.patch//'`
  cp "b/$i" "a/$i"
  if [ $arg_r = false ]; then
    if test -d "a/$pom2"; then
      continue # slozky si nechame na pak 
    fi
      gpatch -s -i "a/$i" "a/$pom2"
  else
    if test -d "a/$pom2"; then
      continue
    fi
      gpatch -R -s -i "a/$i" "a/$pom2"
  fi
  rm "a/$i"

done
# zjistime, ktere soubory nebyli opatchovany
echo "`find a/* | grep .patch | sed 's/a\///'`" | while read -r i; do
  if [ -z $i ]; then
    break
  fi
  pom=`echo "$i" | sed 's/.patch//'`
  if test -z `ls "a/$i"`; then
# pripad aplikace na jine nez sousedni verze
    echo "Varovani: Neprazdny adresar se shodnym jmenem. Ke jmenu bude pridano 2" >&2
    mv "a/$i" "a/$i-2"
  else
    rmdir "a/$pom"
    if $arf_r; then
      gpatch -R -s -i "a/$i" "a/$pom"
    else
      gpatch -s -i "a/$i" "a/$pom"
    fi
  fi
  rm "a/$i"
done
# c je adresar ktery bude zabalen
mv a c
cd $workdir
}
###########################################################################
###########################################################################
############################ BEGIN ########################################
trap cleanup 1
trap cleanup 2
trap cleanup 3
trap cleanup 6
trap cleanup 15

arg_o=false; arg_l=false; arg_c=false; arg_p=false; arg_r=false
workdir=`pwd`

if [ "$*" = "" ]; then
	printf "$help"
	exit 0
fi


while getopts :o:lcpr param
do      case "$param" in
	o)      soubor=$OPTARG
		arg_o=true;;
        l)     	arg_l=true;;
        c)	arg_c=true;;
	p)	arg_p=true;;
	r)	arg_r=true;;
        *)      printf "$help"
                exit 1;;
	esac
done

OPTIND=`expr $OPTIND - 1`

shift $OPTIND
# povinne argumenty
if [ ! $arg_l = true -a ! $arg_c = true -a ! $arg_p = true ] ; then
	printf "$help" >&2
	exit 1
fi
# -p bez -o
if [ $arg_p = true -a $arg_o = false ]; then
	printf "$help" >&2
	exit 1
fi
# -c bez -o
if [ $arg_c = true -a $arg_o = false ]; then
	printf "$help" >&2
	exit 1
fi	
# -o bez -c / -p
if [ $arg_o = true -a ! \( $arg_p = true -o $arg_c = true \) ]; then
	printf "$help" >&2
	exit 1
fi
# zbyle argumenty - archivy
if [ "$#" -eq 2 ]; then
	arch1=$1
	arch2=$2	
else
  	printf "$help" >&2
	exit 1
fi 
# vytvoreni adresare v /tmp
mytmp=`mktemp -d -q /tmp/ardiff-XXXXX`
# rozbaleni
unpack

if $arg_l; then
  list
  sort $mytmp/LIST
fi

if $arg_c; then
  createDiff
  pack
fi

if $arg_p; then
  applyDiff
  pack
fi

rm -r $mytmp

exit 0
              
