# Laravel languages installer

Install translation files for any language with a command in your laravel projects. The language files will be downloaded from the awesome [cauoecs languages repository](https://github.com/caouecs/Laravel-lang).

### Requirements
* PHP 5.5 or higher.
* Laravel >= 5.1

## Installation

Add the package to your composer.json:

```
composer require ablunier/laravel-lang-installer
```

Add the service provider in app.php:

```
    Ablunier\Laravel\Translation\LanguageInstallerServiceProvider::class,
```

Publish the package's assets:

```
php artisan vendor:publish
```

## Configuration

Edit the 'lang-installer.php' file in your config folder to add your required languages and files.

## Usage

Execute the command:

```
php artisan lang:install
```
