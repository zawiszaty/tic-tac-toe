# Tic Tac Toe
[![CircleCI](https://circleci.com/gh/zawiszaty/tic-tac-toe.svg?style=svg)](https://circleci.com/gh/zawiszaty/tic-tac-toe)

Simple game in php to develop my OOP design skill

## How to run Linux/Mac
```
composer install
make test
```

## How to run Windows
```
composer install
./vendor/bin/phpstan analyse -l 7 -c phpstan.neon src
./vendor/bin/php-cs-fixer fix --allow-risky=yes
./vendor/bin/phpunit
```