# Fastrains (Api)
## Installation

1. Install Composer
2. Install dependencies.
```console
composer install
```
3. Setup Project
```console
php bin/console app:setup
```
4. Run web server
```console
php -S 0.0.0.0:8000 -t public
```

## Run tests
* PHPUnit
```console
composer phpunit
```
* Behat
```console
composer behat
```
* Both PHPUnit and Behat
```console
composer tests
```  
