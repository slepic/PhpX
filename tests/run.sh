#/bin/bash

path=`readlink -f $0`
path=`dirname $path`
path=`dirname $path`

"$path/vendor/phpunit/phpunit/phpunit" --bootstrap "$path/vendor/autoload.php" "$path/tests/$1"
exit $?
