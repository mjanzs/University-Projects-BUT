#!/bin/sh

#Martin Jany¹ - xjanys00, IOS 1. projekt B

#lokalizace na Krokovi bez se bez ni nerolisujou velka/mala pismena
LANG=en_GB.ISO8859-2

head="<html>
<style>
.pid { color:darkred; }
.ts { color:navy; }
.number { color:red; }
.const { color:green; }
.string { color:blue; }
.hlcall { text-decoration:none; font-weight:bold; color:black; }
.call { text-decoration:none; color:olive; }
</style>
<body><pre>
"

tail="</pre></body></html>"
help="hltrace zvyrazni syntax stopy od strace.
Pouziti: hltrace [volby] <stopa.strace >stopa.html
Volby:
  -s SYSCALL  Specialne zvyrazni volani SYSCALL.
"

while getopts s:h opt; do
case "$opt" in
	s) syscall=$OPTARG ;;
	h) printf "$help" >&2
	   exit 0;;
	*) exit 1;;
esac
done

OPTIND=`expr $OPTIND - 1`

shift $OPTIND

if [ "$#" -ne 0 ]; then
printf "$help" >&2
exit 1
fi

printf "$head"

cat /dev/stdin | \
# & < >
sed 's/&/\&amp;/g' | sed 's/</\&lt;/g' | sed 's/>/\&gt;/g' | \
# "string" s escapovanymi \"
sed -r 's:("([^"]|\\["])*"):<span class="string">\1<\/span>:g' | \
# PID
sed -r 's:^([0-9]+):<span class="pid">\1<\/span>:' | \
# Relativni cas udaje
sed -r 's: ([0-9]\.[0-9]+) : <span class="ts">\1<\/span> :' | \
# cisla v argumentech
sed -r 's: = (-{0,1}[0-9]+|0x[a-fA-F0-9]+): = <span class="number">\1<\/span>:g' | \
# navratove hodnoty
sed -r 's:( +|^)([a-z0-9_]+)\(:\1<a href="http\:\/\/www\.kernel\.org\/doc\/man-pages\/online\/pages\/man2\/\2\.2\.html" class="call">\2<\/a>(:' | \
# konstanty
sed -r 's:([A-Z]+[0-9A-Z_]+):<span class="const">\1<\/span>:g' | \
# argumenty fci
sed -r 's:([(, ])(-{0,1}[0-9]+|0x[a-fA-F0-9]+)([,)]):\1<span class="number">\2<\/span>\3:g' | \
# uzivatelske zvyrazneni
sed -r "s|class=\"call\">$syscall<\/a>|class=\"hlcall\">$syscall<\/a>|"

printf "$tail"


