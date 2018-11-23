#!/bin/bash

path=`readlink -f "$0"`
path=`dirname "$path"`

"$path/pre-commit/run-tests.sh"
exit $?
