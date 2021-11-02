# Teachaway Coding Challenge. Backend - Extending SWAPI The Star Wars API

Challenge done using [Slim PHP micro framework](https://www.slimframework.com).

This simple API allows you to manage resources such as: vehicles and starships from [SWAPI](https://swapi.dev/documentation).

Main technologies used: `PHP 7, Slim 3, Guzzle, MySQL and dotenv.`


## :gear: QUICK INSTALL:

### Requirements:

- Git.
- Composer.
- PHP 7.4+ or 8.0+.
- MySQL.
- PHP extensions php-mysql, php-xml and php-mbstring
` sudo apt-get install php-mysql php-xml php-mbstring`


### Using Git:

In your terminal execute this commands:

```bash
$ git clone https://github.com/emestanza/teachaway-challenge.git && cd teachaway-challenge
$ cp .env.example .env
$ composer install
$ composer restart-db
$ composer test
$ composer start
```


## :package: DEPENDENCIES:

### LIST OF REQUIRE DEPENDENCIES:

- [slim/slim](https://github.com/slimphp/Slim): Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
- [palanik/corsslim](https://github.com/palanik/CorsSlim): Cross-origin resource sharing (CORS) middleware for PHP Slim.
- [guzzlehttp/guzzle](https://github.com/guzzle/guzzle): PHP HTTP client that makes it easy to send HTTP requests and trivial to integrate with web services.
- [vlucas/valitron](https://github.com/vlucas/valitron): Valitron is a simple, minimal and elegant stand-alone validation library with NO dependencies.


### LIST OF DEVELOPMENT DEPENDENCIES:

- [phpunit/phpunit](https://github.com/sebastianbergmann/phpunit): The PHP Unit Testing framework.

## :books: DOCUMENTATION:

### ENDPOINTS:

#### INFO:

- Help: `GET /`


#### VEHICLES:

- Search by name: `GET /teachaway/vehicle/{name}`

- Set initial quantity to vehicles: `PUT /teachaway/vehicle/{id}`

- Increase vehicles quantity: `PUT '/teachaway/vehicle/increase/{id}`

- Decrease vehicles quantity: `PUT /teachaway/vehicle/decrease/{id}`


#### STARSHIPS:

- Search by name: `GET /teachaway/starship/{name}`

- Set initial quantity to starships: `PUT /teachaway/starship/{id}`

- Increase starships quantity: `PUT '/teachaway/starship/increase/{id}`

- Decrease starships quantity: `PUT /teachaway/starship/decrease/{id}`


### HELP AND DOCS:

For more information on how to use the REST API, see the following documentation available on [Postman Documenter](https://www.postman.com/lively-rocket-2135/workspace/teachaway/documentation/671512-5e6ae052-0be0-4ae6-bd3d-c3587a09d122).


### IMPORT WITH POSTMAN:

All the information of the API, prepared to download and use as postman collection: [Import Collection](https://www.postman.com/lively-rocket-2135/workspace/teachaway/documentation/671512-5e6ae052-0be0-4ae6-bd3d-c3587a09d122).

[![Run in Postman](https://run.pstmn.io/button.svg)](https://god.gw.postman.com/run-collection/671512-5e6ae052-0be0-4ae6-bd3d-c3587a09d122?action=collection%2Ffork&collection-url=entityId%3D671512-5e6ae052-0be0-4ae6-bd3d-c3587a09d122%26entityType%3Dcollection%26workspaceId%3D12aca00c-65af-4711-97e9-13137d5b2e99#?env%5BTeachaway%20Dev%5D=W3sia2V5IjoiYmFzZV91cmwiLCJ2YWx1ZSI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MCIsImVuYWJsZWQiOnRydWV9XQ==)

## :heart: DO YOU LIKE THE PROJECT?

Hire me, you won't regret it ;) hehe.


## :page_facing_up: LICENSE

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat
