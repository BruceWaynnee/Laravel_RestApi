<?php

namespace App\Models\Api;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Category extends Model
{
    use HasFactory;

    /**
     * Table name.
     * @var String
     */
    protected $table = 'categories';

    /**
     * Primary key
     * @var Integer
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * @var Array
     */
    protected $fillable = [
        'name',
        'description',

    ];

    /**
     * ##############################
     *    Module Helper Functions
     * ##############################
     */
        // Category Helper Functions [BEGIN]
            /**
             * Get all category records from database.
             * @return RespondObject [data: data_result, message: result_message]
             */
            public static function getCategories(){
                $respond = (object)[];

                try {
                    $categories = Category::all();
                    $respond->data    = $categories;
                    $respond->message = 'Success getting all category records from database';
                } catch(Exception $ex) {
                    $respond->data    = false;
                    $respond->message = 'Problem occured while trying to get category records from database!';
                }

                return $respond;
            }

            /**
             * Get specific category record based on given 
             * id parameter from database.
             * @param Integer $id
             * @return RespondObject [data: data_result, message: result_message]
             */
            public static function getCategory($id){
                $respond = (object)[];

                try {
                    $category = Category::findOrFail($id);
                    $respond->data    = $category;
                    $respond->message = 'Category record found';
                } catch(Exception $ex) {
                    $respond->data    = false;
                    $respond->message = 'Category records not found!';
                }

                return $respond;
            }

            /**
             * Scope like custom query function, query category based
             * on given field name and field value.
             * @param String $field
             * @param String $value
             * @return RespondObject [data: data_result, message: result_message]
             */
            public static function scopeLike($field, $value){
                $respond = (object)[];

                try {
                    $category = Category::where($field, 'LIKE', '%'.$value.'%')->get();
                    $respond->data    = $category;
                    $respond->message = 'Successful getting category record';
                } catch(ModelNotFoundException | Exception $ex) {
                    $respond->data    = false;
                    $respond->message = 'Problem occured while trying to search category record by '.$field.', please try again!';
                }

                return $respond;
            }
        // Category Helper Functions [END]

        // Helper Functions [BEGIN]
            /**
             * 
             */
        // Helper Functions [BEGIN]

    /**
     * ########################
     *     Helper Functions
     * ########################
     */
        /**
         * One category to many product.
         * @return App\Api\Model\Product
         */
        public function products(){
            return $this->hasMany(
                Product::class,
                'category_id',
            );
        }

    /**
     * ######################
     *      Relationship
     * ######################
     */
        /**
         * 
         */

}