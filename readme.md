# CONFIT-monolith

1.Build, start and install the docker images from your terminal:
```bash
make build
make start
make composer-install
make env-dev
```

2.Make sure that you have installed migrations/seeds:
```bash
make migrate
make seed
```

3.Set key for application:
```bash
make key-generate
```

4.Check and open in your browser next url: [http://localhost](http://localhost).

## Start and stop environment
Please use next make commands in order to start and stop environment:
```bash
make start
make stop
```


## Architecture & packages
* [Laravel 9](https://laravel.com)
* [laravel-migrations-organiser](https://github.com/JayBizzle/Laravel-Migrations-Organiser)
* [phpunit](https://github.com/sebastianbergmann/phpunit)
* [laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
* [scriptsdev](https://github.com/neronmoon/scriptsdev)
* [composer-bin-plugin](https://github.com/bamarni/composer-bin-plugin)
* [ergebnis/composer-normalize](https://github.com/ergebnis/composer-normalize)
* [composer-unused](https://packagist.org/packages/icanhazstring/composer-unused)
* [composer-require-checker](https://packagist.org/packages/maglnet/composer-require-checker)
* [security-advisories](https://github.com/Roave/SecurityAdvisories)
* [php-coveralls](https://github.com/php-coveralls/php-coveralls)
* [easy-coding-standard](https://github.com/Symplify/EasyCodingStandard)
* [PhpMetrics](https://github.com/phpmetrics/PhpMetrics)
* [phpcpd](https://packagist.org/packages/sebastian/phpcpd)
* [phpmd](https://packagist.org/packages/phpmd/phpmd)
* [phpstan](https://packagist.org/packages/nunomaduro/larastan)
* [phpinsights](https://packagist.org/packages/nunomaduro/phpinsights)
* [rector](https://packagist.org/packages/rector/rector)

## Guidelines
* [Commands](docs/commands.md)
* [Development](docs/development.md)
* [Testing](docs/testing.md)
* [IDE PhpStorm configuration](docs/phpstorm.md)
* [Xdebug configuration](docs/xdebug.md)

## License
[The MIT License (MIT)](LICENSE)
