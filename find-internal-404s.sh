#!/bin/bash
# Aufruf mit der URL des aktuellen "raw log" von Travis CI

curl -L -- "$1" | grep --before=1 "ERROR 404" | grep -v "ERROR 404" | egrep -v "^--$" | sed -e 's+:.$++'
