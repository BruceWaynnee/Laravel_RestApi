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

# Testing The API
#### Date( Saturaday, April/23rd/2022 )

User API
| To              | Method        | URL  						   	          |
| --------------- |:-------------:| -----------------------------------------:|
| Register User   | ```POST```    | http://localhost:8000/api/users/register  |
| Login           | ```POST```    | http://localhost:8000/api/users/login     |
| logout          | ```POST```    | http://localhost:8000/api/users/logout    |
|                 |               |                                           |
###### Mandatory Request Variable Name To:
Register User
 - ```name```
 - ```email```
 - ```password```
 - ```password_confirmation```

Login
 - ```email```
 - ```password```

Logout
 - ```You need to send it with your Token Api in order to log the user out!```
---

Category API
| To              | Method        | URL  								                              |
| --------------- |:-------------:| -----------------------------------------------------------------:|
| List Categories | ```GET```     | http://localhost:8000/api/categories   		                      |
| Add Category    | ```POST```    | http://localhost:8000/api/categories   		                      |
| Show Category   | ```GET```     | http://localhost:8000/api/categories/1                            |
| Search Category | ```GET```     | http://localhost:8000/api/search/{field}/{value} ex name/drinks   |
| Edit Category   | ```PATCH```   | http://localhost:8000/api/categories/1/edit                       |
| Delete Category | ```DELETE```  | http://localhost:8000/api/categories/1                            |
|                 |               |                                                                   |
###### Mandatory Request Variable Name To:
Add Category
 - ```name```
 - ```description```
 - ```You need to send it with your Token Api in order to process this action!```

Edit Category
 - ```name```
 - ```description```
 - ```You need to send it with your Token Api in order to process this action!```

Delete Category
 - ```You need to send it with your Token Api in order to process this action!```
---

Product API
| To              | Method        | URL  								                              |
| --------------- |:-------------:| -----------------------------------------------------------------:|
| List Products   | ```GET```     | http://localhost:8000/api/products   		                      |
| Add Product     | ```POST```    | http://localhost:8000/api/products   		                      |
| Show Product    | ```GET```     | http://localhost:8000/api/products/1                              |
| Search Product  | ```GET```     | http://localhost:8000/api/search/{field}/{value} ex name/iphone   |
| Edit Product    | ```PATCH```   | http://localhost:8000/api/products/1/edit                         |
| Delete Product  | ```DELETE```  | http://localhost:8000/api/products/1                              |
|                 |               |                                                                   |
###### Mandatory Request Variable Name To:
Add Product
 - ```name```
 - ```cost```
 - ```barcode```
 - ```category_id```
 - ```country_of_origin```
 - ```You need to send it with your Token Api in order to process this action!```

Edit Product
 - ```name```
 - ```cost```
 - ```barcode```
 - ```category_id```
 - ```country_of_origin```
 - ```You need to send it with your Token Api in order to process this action!```

Delete Product
 - ```You need to send it with your Token Api in order to process this action!```
---

Size API
| To          | Method       | URL  								                          |
| ----------- |:------------:| --------------------------------------------------------------:|
| List sizes  | ```GET```    | http://localhost:8000/api/sizes   		                      |
| Add size    | ```POST```   | http://localhost:8000/api/sizes   		                      |
| Show size   | ```GET```    | http://localhost:8000/api/sizes/1                              |
| Search size | ```GET```    | http://localhost:8000/api/search/{field}/{value} ex name/small |
| Edit size   | ```PATCH```  | http://localhost:8000/api/sizes/1/edit                         |
| Delete size | ```DELETE``` | http://localhost:8000/api/sizes/1                              |
|             |              |                                                                |
###### Mandatory Request Variable Name To:
Add Size
 - ```name```
 - ```slug```
 - ```description```
 - ```You need to send it with your Token Api in order to process this action!```

Edit Size
 - ```name```
 - ```slug```
 - ```description```
 - ```You need to send it with your Token Api in order to process this action!```

Delete Size
 - ```You need to send it with your Token Api in order to process this action!```
---

Color API
| To           | Method       | URL  								                           |
| ------------ |:------------:| --------------------------------------------------------------:|
| List Colors  | ```GET```    | http://localhost:8000/api/colors   		                       |
| Add color    | ```POST```   | http://localhost:8000/api/colors   		                       |
| Show color   | ```GET```    | http://localhost:8000/api/colors/1                             |
| Search color | ```GET```    | http://localhost:8000/api/search/{field}/{value} ex name/black |
| Edit color   | ```PATCH```  | http://localhost:8000/api/colors/1/edit                        |
| Delete color | ```DELETE``` | http://localhost:8000/api/colors/1                             |
|              |              |                                                                |
###### Mandatory Request Variable Name To:
Add Size
 - ```name```
 - ```slug```
 - ```description```
 - ```You need to send it with your Token Api in order to process this action!```

Edit Size
 - ```name```
 - ```slug```
 - ```description```
 - ```You need to send it with your Token Api in order to process this action!```

Delete Size
 - ```You need to send it with your Token Api in order to process this action!```
---