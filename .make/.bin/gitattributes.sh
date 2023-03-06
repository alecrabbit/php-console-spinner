#!/usr/bin/env bash

function add_export_ignore_entry {
  local item="$1"
  local file="$2"
  local ignores="${3:-}"
  local excludes="${4:-}"
  # Remove leading forward slash from item path
  item=${item#/}
  if [[ ! "${ignores[*]}" =~ ${item} ]] && [[ ! "${excludes[*]}" =~ ${item} ]]; then
      echo "$item export-ignore" >>"$file"
  fi
}

DIRECTORY=${1:-$(pwd)}
KEEP_FILE=".gitattributes.keep"
IGNORE_FILE=".gitignore"
FILE="$DIRECTORY/.gitattributes"

# Get the list of files and directories to exclude
EXCLUDES=$(awk '{print $1}' "$KEEP_FILE" | sed 's|^\.*/\{0,1\}||')

# Get the list of files and directories to ignore
IGNORES=$(awk '{print $1}' "$IGNORE_FILE" | sed 's|^\.*/\{0,1\}||')

# Get the contents of the directory and sort them alphabetically
CONTENTS=$(find "$DIRECTORY" -mindepth 1 -maxdepth 1 -exec basename {} \; | sort)

# Create an empty file
> "$FILE"

# Loop over each file or directory in the contents
while read -r item; do
  if [[ -d "$item" ]]; then
    item="$item/"
  fi
  add_export_ignore_entry "$item" "$FILE" "$IGNORES" "$EXCLUDES"
done <<<"$CONTENTS"
