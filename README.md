# Lucy - Laravel PHP Skeleton

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Lucy is the skeleton backend app used at Osedea. This is currently using Laravel 5.3.

It provides common functionalities to rapidly start an api based application since starting from scratch takes a long time.

## Getting Started

* First, clone the project

`git clone git@gitlab.com:osedea-internal/lucy.git`

* Link the project to your homestead machine or laradock then run the following commands inside your project. You should also add an entry in `etc/hosts`

`composer install`

`cp .env.example .env` (modify .env and add in your database name)

`php artisan key:generate && php artisan jwt:generate`

`php artisan migrate`

`php artisan db:seed`

`php artisan apidocs:generate api/v1`

`npm install` (mind the node version. Check .node-version)

`gulp`

* You should be good to go. To generate new resources, use the following commands:

`php artisan make:api test`

`php artisan make:admin test`

## Features

The project is constantly being improved, but should be used with care.

* Token Based Authentication (with JWT "JSON Web Tokens") using [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
* User endpoints (Login, Logout, Register, Query, Update, Delete)
* Authentication throttling
* ACL using roles & permissions (the recommended way by Laravel)
* Automated permission system based on models (NEVER EVER EVER add permissions manually to the database)
* Automatic API Documentation generator using [f2m2/apidocs](https://github.com/f2m2/apidocs)
* UUID instead of incremental id for all models using [webpatser/laravel-uuid](https://github.com/webpatser/laravel-uuid)
* Supports CORS "Cross-Origin Resource Sharing"
* Sending emails (feature comes from Laravel)
* Automatic data pagination (meta links to next and previous data)
* Error logging to database for easy display and debug even if you don't have access to the server
* Action logging to database to keep track of changes to the data
* API Validation with string constants and variables to allow localized and easy error message display on the frontend
* RESTful API
* Ready admin dashboard infrastructure
* Entity generator allowing you to rapidly generate a resource that is immediately available from the admin panel as well
* Push notifications for mobile

TODO some day : add FacebookGraphSDK

## Contribute

To contribute to this skeleton, we use the following process:

 * Clone the repo
 * Create a branch
 * Work
 * Push your changes
 * Make a pull request
 * Wait for review

## Why Lucy?

From [Wikipedia](http://en.wikipedia.org/wiki/Lucy_%28Australopithecus%29):

> Lucy is the common name of AL 288-1, several hundred pieces of bone representing about 40% of the skeleton of a female Australopithecus afarensis.