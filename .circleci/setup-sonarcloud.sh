#!/usr/bin/env bash

SONAR_CLI_ZIP=sonar-scanner-cli-3.2.0.1227-linux.zip
SONAR_CLI_DIR=sonar-scanner-3.2.0.1227-linux

wget https://sonarsource.bintray.com/Distribution/sonar-scanner-cli/$SONAR_CLI_ZIP
unzip $SONAR_CLI_ZIP

sudo ln -s $SONAR_CLI_DIR/bin/sonar-scanner /usr/local/bin/sonar-scanner

sonar-scanner --version
