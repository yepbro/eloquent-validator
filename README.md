# Eloquent Validator

## Getting Started

### Requirements

- PHP >= 8.4

### Installation

```shell
composer yepbro/eloquent-validator
```

## Development

### Docker

Used [Composer PHP docker image](https://github.com/devgine/composer-php) with xdebug, phpunit, phpstan, psalm, phpcs,
php-cs-fixer, phpmd, phpcpd and rector.

```shell
docker-compose build --no-cache
docker-compose up
docker exec -t -i eloquent-validator-php /bin/bash
```

### Tests

Run tests

```shell
vendor/bin/phpunit tests/
```

## Different

### Similar packages

- https://github.com/dwightwatson/validating
- https://github.com/jarektkaczyk/eloquence-validable
- https://github.com/sandeep-daffodilsw/laravel-model-validator
- https://github.com/theriddleofenigma/laravel-model-validation
- https://bitbucket.org/teamhelium/com.helium.eloquent.model-validator/src/master/
- https://github.com/JeffreyWay/Laravel-Model-Validation