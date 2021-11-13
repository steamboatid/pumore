#!/usr/bin/env bash

dirnow=$(dirname $(realpath $0))
dirroot=$(realpath "$dirnow/../..")
printf "\n --- ROOT directory: $dirroot \n"


printf "\n --- LINT CHECK directory: $dirroot/src \n"
for afile in $(find -L $dirroot/src -type f -iname "*.php"); do
	res=$(php -l $afile 2>&1)
	if [[ $( printf "$res" | grep -iv "no syntax errors" | wc -l) -gt 0 ]]; then
		printf "\n$res \n\n"
		exit 1;
	else
		printf "."
	fi
done

printf "\n --- LINT CHECK directory: $dirroot/tests \n"
for afile in $(find -L $dirroot/tests -type f -iname "*.php" | grep -iv "_files"); do
	res=$(php -l $afile 2>&1)
	if [[ $( printf "$res" | grep -iv "no syntax errors" | wc -l) -gt 0 ]]; then
		printf "\n$res \n\n"
		exit 1;
	else
		printf "."
	fi
done

printf "\n\n"
