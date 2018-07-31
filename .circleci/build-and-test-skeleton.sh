#!/usr/bin/env bash

RECTUM_DIR=`pwd`
SKELETON_DIR=/tmp/skeleton

rm -rf $SKELETON_DIR

git clone git@github.com:lencse/rectum-skeleton.git $SKELETON_DIR
cd $SKELETON_DIR

head -n +1 composer.json > composer.json.1
echo "\"repositories\": [{\"type\": \"path\", \"url\": \"$RECTUM_DIR\"}]," >> composer.json.2
tail -n +2 composer.json > composer.json.3
cat composer.json.1 composer.json.2 composer.json.3 > composer.json

head -n +1 phpunit.xml > phpunit.xml.1
echo "<php><env name=\"RECTUM_PROJECT_ROOT\" value=\"$SKELETON_DIR\" /></php>" >> phpunit.xml.2
tail -n +2 phpunit.xml > phpunit.xml.3
cat phpunit.xml.1 phpunit.xml.2 phpunit.xml.3 > phpunit.xml

composer install
composer test

./smoke-test.sh
