# Laravel_RestApi
Laravel 8 RESTful_API with Sanctum API authentication.
---

## Installation
- go to gitlab and clone this project ``` https://github.com/BruceWaynnee/Laravel_RestApi.git ```
- cd into project directory, by default project name should be ``` Laravel_RestApi ```
- copy the .env.example to your .env by using this command ``` cp .env.example .env ```
- run these command to generate Laravel vendor folder ``` composer install ``` and ``` composer update ```

- generate key in .env by running ``` php artisan key:generate ```
- on the .env file, replace DB_DATABASE with your database
- execute this command for database seed and migration ``` php artisan migrate:fresh --seed ```
- run development serve using ``` php artisan serve ```
- open your project and enjoy it, since this is about RestFul API, make sure to use any api testing app for example: PostMan, Katalon Studio, Eggplant ...

# Packages That This Project Used
### Working With Sanctum API Authentication
- Package name ``` Laravel Sanctum ```
- Open your composer and execute following command to install the package
    -> ``` composer require laravel/sanctum ```
- Documentation: https://laravel.com/docs/8.x/sanctum

### 
