#!/usr/bin/env bash
script_dir="$(dirname "$0")"
if [[ ${script_dir} != './bin' ]]
then
  cd ${script_dir}
fi

. colors.sh "$@"
. settings.sh "$@"
. functions.sh "$@"
