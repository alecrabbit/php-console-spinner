#!/usr/bin/env bash

# The directory to create the .gitattributes file in
directory=${1:-$(pwd)}

# Create an empty .gitattributes file
> "$directory/.gitattributes"

# Collect the contents of the directory and exclude those listed in .gitattributes.keep
contents=$(find "$directory" -mindepth 1 -maxdepth 1 -not -path '*/.gitattributes.keep' -printf '%P\n')

# Loop over each file or directory in the contents
while read -r item; do
  # Check if the item is a directory
  if [[ -d "$item" ]]; then
    # If the item is a directory, add it to the .gitattributes file with the "export-ignore" attribute
    echo "$item/ export-ignore" >> "$directory/.gitattributes"
  else
    # If the item is a file, add it to the .gitattributes file with the "export-ignore" attribute
    echo "$item export-ignore" >> "$directory/.gitattributes"
  fi
done <<< "$contents"
