<?php

namespace App\Models\Api;
use Illuminate\Database\Eloquent\Model;

use App\Models\Util\ModuleQueryMethods\ModuleQueries;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * Table Name.
     * @var String
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     * @var Array
     */
    protected $fillable = [
        'name',
        'barcode',
        'cost',
        'category_id',
        'country_of_origin',
        'brand_id',
        
    ];

    /**
     * ###################################
     *    Requests Validation Functions
     * ###################################
     */
        /**
         * Validate if request has data and the data existing in the database.
         * @param \Illuminate\Http\Request $request
         * @param Integer $productId
         * 
         * @return ObjectRespond [ data: data_result, message: result_message ]
         */
        public static function validateExistingModulesOfCorrespondingProduct( $request, $productId ){
            $respond = (object)[
                'data'    => true,
                'message' => 'All the data are existing',
            ];

            // get product record
            $product = ModuleQueries::findModelRecordById('product', $productId, 'API');
            if( !$product->data ){
                return $product;
            }
            $product = $product->data;

            // validate category records
            if( $request->has('category_id') ){
                $category = ModuleQueries::findModelRecordById('category', $request['category_id'], 'API');
                if( !$category->data ){
                    return $category;
                }
            }
    
            // validate brand records
            if( $request->has('brand_id') ){
                $brand = ModuleQueries::findModelRecordById('brand', $request['brand_id'], 'API');
                if( !$brand->data ){
                    return $brand;
                }
            }

            $respond->product = $product;

            return $respond;
        }

        /**
         * Validate and get mandatory module records based on requests parameter, from the database.
         * @param \Illuminate\Http\Request $request
         * @return ObjectRespond [ data: data_result, message: result_message ]
         */
        public static function requestsValidation($request){
            $respond = (object)[
                'data'    => true,
                'message' => 'Successful getting all mandatory module records from database',
            ];

            // get category record
            $category = ModuleQueries::findModelRecordById('category', $request['category_id'], 'API');
            if( !$category->data ){
                return $category;
            }
            $category = $category->data;

            // get brand record
            $brand = ModuleQueries::findModelRecordById('brand', $request['brand_id'], 'API');
            if( !$brand->data ){
                return $brand;
            }
            $brand = $brand->data;

            // extra fields
            $name            = $request['name'];
            $barcode         = $request['barcode'];
            $countryOfOrigin = $request['country_of_origin'];

            $respond->brand           = $brand;
            $respond->category        = $category;
            $respond->name            = $name;
            $respond->barcode         = $barcode;
            $respond->countryOfOrigin = $countryOfOrigin;

            return $respond;
        }
}
