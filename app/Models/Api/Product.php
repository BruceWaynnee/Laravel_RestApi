<?php

namespace App\Models\Api;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Product extends Model
{
    use HasFactory;

    /**
     * Table Name
     * @var String
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable
     * @var Array
     */
    protected $fillable = [
        'name',
        'barcode',
        'cost',
        'country_of_origin',

    ];

    /**
     * ##############################
     *    Module Helper Functions
     * ##############################
     */
        
        // Product Helper Functions [BEGIN]
            /**
             * Get all product records from database.
             * @return ObjectRespond [ data: data_result, message: result_message ]
             */
            public static function getProducts(){
                $respond = (object)[];

                try {
                    $products = Product::all();
                    $respond->data    = $products;
                    $respond->message = 'Successfully fetching all product records from database';
                } catch( Exception | Throwable $ex ) {
                    $respond->data    = false;
                    $respond->message = 'Problem occured while trying to fetch product records from database!';
                }

                return $respond;
            }

            /**
             * Get sepcific product based on given id parameter from database.
             * @param Integer $id
             * @return ObjectRespond [ data: data_result, message: result_message ]
             */
            public static function getProduct( $id ){
                $respond = (object)[];

                try {
                    $product = Product::findOrFail( $id );
                    $respond->data = $product;
                    $respond->message = 'Product record found';
                } catch( ModelNotFoundException $ex ) {
                    $respond->data    = false;
                    $respond->message = 'Product record not found!';
                }

                return $respond;
            }

            /**
             * Scope like custom query function, query product based 
             * on given field and field value.
             * @param String $field
             * @param String $value 
             * @return ObjectRespond [ data: data_result, message: result_message ]
             */
            public static function scopeLike( $field, $value ){
                $respond = (object)[];
                $field = strtolower($field);

                try {
                    $product = Product::where($field, 'LIKE', '%'.$value.'%')->get();
                    $respond->data = $product;
                    $respond->message = 'Sucessful getting product record by '.$field;
                } catch( ModelNotFoundException | Exception $ex ) {
                    $respond->data    = false;
                    $respond->message = 'Problem occured while trying to search product by '.$field.', please try again!';
                }

                return $respond;
            }

            /**
             * 
             */
        // Product Helper Functions [END] 
        
        // Helper Functions [BEGIN]
            /**
             * 
             */
        // Helper Functions [BEGIN]

    /**
     * ##############################
     *    Module Helper Functions
     * ##############################
     */

}
