## Introduction

Laravel Passport is an OAuth2 server and API authentication package that is simple and enjoyable to use.
This is just a fork of official [Laravel Passport](https://github.com/laravel/passport) with options of
multiple database and connections.

## Official Documentation

Follow official documentation at [Laravel website](http://laravel.com/docs/master/passport) for every tasks except those mentioned here.

## Multiple database and connection setup

#### Installation

- To get started, install Passport via the Composer package manager:
```php
compser require Andatech/passport
```

- Add the following line in providers list within `app.php` inside your config directory.
```php
Andatech\Passport\PassportServiceProvider::class
```

- Provide your connection and database name during passport installation.
```php
php artisan passport:install --connection=<your connection name> --database=<your database name>
```
> If you are installing for default database and connection you can skip options during passport install.

#### Run-time setup:

- Publish connection file to your app directory
```php
php artisan vendor:publish --tag=multiple-passport-connection
```

> Publishes connection settings file to your app directory `(app/Andatech/Passport/Connection.php)`.
> Let you update the file with your run-time connection and database selector logic.

## License

Laravel Passport is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
