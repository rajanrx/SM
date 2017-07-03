#!/usr/bin/env bash
set -ex

# Test php linting using code sniffer
./bin/phpcs -p

# Test php classes using mess detector
 ./bin/phpmd --exclude '*Test.php,*TestCase.php' ./src/ text codesize

# Run unit tests
 ./bin/phpunit

# Find issues using php smart analyser
# Fixme: Known issue https://github.com/ovr/phpsa/issues/331
./bin/phpsa check src/