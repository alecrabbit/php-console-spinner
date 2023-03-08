#!/usr/bin/env bash
FILE=".start_time"
START=$(date +"%s")
echo "${START}" > $FILE
