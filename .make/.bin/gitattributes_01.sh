#!/usr/bin/env bash

## The directory to create the .gitattributes file in
#directory=${1:-$(pwd)}
#
## Create an empty .gitattributes file
#> "$directory/.gitattributes"
#
## Collect the contents of the directory and exclude those listed in .gitattributes.keep
#contents=$(find "$directory" -mindepth 1 -maxdepth 1 -not -path '*/.gitattributes.keep' -printf '%P\n')
#
## Loop over each file or directory in the contents
#while read -r item; do
#  # Check if the item is a directory
#  if [[ -d "$item" ]]; then
#    # If the item is a directory, add it to the .gitattributes file with the "export-ignore" attribute
#    echo "$item/ export-ignore" >> "$directory/.gitattributes"
#  else
#    # If the item is a file, add it to the .gitattributes file with the "export-ignore" attribute
#    echo "$item export-ignore" >> "$directory/.gitattributes"
#  fi
#done <<< "$contents"

DIRECTORY=${1:-$(pwd)}
KEEP_FILE=".gitattributes.keep"

# Get the list of files and directories to exclude
EXCLUDES=$(awk '{print $1}' "$KEEP_FILE" | sed 's|^/||')

echo "Excluding: \n ${EXCLUDES[*]}";

CONTENTS=$(find "$DIRECTORY" -mindepth 1 -maxdepth 1 -exec basename {} \;)

echo "CONTENTS: \n ${CONTENTS[*]}";

## Collect all files and directories, except for the ones listed in .gitattributes.keep
#while IFS= read -r -d '' FILE; do
#  if [[ ! " ${EXCLUDES[*]} " =~ " ${FILE#./} " ]]; then
#    echo "${FILE#./} export-ignore" >> "$DIRECTORY/.gitattributes"
#  fi
#done < <(find "$DIRECTORY" -mindepth 1 ! -path "*/$KEEP_FILE" -print0)
