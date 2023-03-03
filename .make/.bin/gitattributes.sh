#!/usr/bin/env bash

DIRECTORY=${1:-$(pwd)}
KEEP_FILE=".gitattributes.keep"

# Get the list of files and directories to exclude
EXCLUDES=$(awk '{print $1}' "$KEEP_FILE" | sed 's|^/||')

# Get the contents of the directory and sort them alphabetically
CONTENTS=$(find "$DIRECTORY" -mindepth 1 -maxdepth 1 -exec basename {} \; | sort)

# Create an empty .gitattributes file
> "$DIRECTORY/.gitattributes"

# Loop over each file or directory in the contents
while read -r item; do
    if [[ ! "${EXCLUDES[*]}" =~ "${item#./}" ]]; then
        # Check if the item is a directory
        if [[ -d "$item" ]]; then
          # If the item is a directory, add it to the .gitattributes file with the "export-ignore" attribute
          echo "$item/ export-ignore" >> "$DIRECTORY/.gitattributes"
        else
          # If the item is a file, add it to the .gitattributes file with the "export-ignore" attribute
          echo "$item export-ignore" >> "$DIRECTORY/.gitattributes"
        fi
    fi
done <<< "$CONTENTS"
