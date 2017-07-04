# SM [![Build Status](https://travis-ci.org/rajanrx/SM.svg?branch=master)](https://travis-ci.org/rajanrx/SM)

Simple project to show recommended movies 

# usage

You need to have PHP 7.1 or above to run this project.

Either clone this Repo 
```
git clone https://github.com/rajanrx/SM.git && composer install
```
and then run command 
```
php command.php --genre 'Comedy' --time '12:00'
```

OR Install using composer 
```
composer require rajan/sm:^1.0.1
```

Then run using command line 
```
php vendor/rajan/sm/command.php --genre 'Comedy' --time '12:00'
```

# Test Coverage  

To generate the report run and you can access coverage html
```
./bin/phpunit --coverage-html ./report
```
![Test Coverage](https://github.com/rajanrx/SM/blob/master/Report/test-coverage.png)
