<?php

namespace App\Models\Api;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Size extends Model
{
    use HasFactory;

    /**
     * Table name.
     * @var String
     */
    protected $table = 'sizes';

    /**
     * Primary key.
     * @var Integer
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * @var Array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',

    ];

    /**
     * ################################
     *     Modules Helper Functions
     * ################################
     */
        // Size Helper Functions [BEGIN]
            /**
             * Get all size records from database.
             * @return ObjectRespond [data: data_result, message: result_message]
             */
            public static function getSizes(){
                $respond = (object)[];

                try {
                    $sizes = Size::all();
                    $respond->data    = $sizes;
                    $respond->message = 'Successful getting all size records from database';
                } catch(Exception | Throwable $ex) {
                    $respond->data    = false;
                    $respond->message = 'Problem occured while trying to get size record from database!';
                }

                return $respond;
            }

            /**
             * Get specific size record based on given 
             * id parameter from database.
             * @param Integer $id
             * @return ObjectRespond [data: data_result, message: result_message]
             */
            public static function getSize( $id ){
                $respond = (object)[];

                try {
                    $size = Size::findOrFail($id);
                    $respond->data    = $size;
                    $respond->message = 'Size record found';
                } catch(ModelNotFoundException $ex) {
                    $respond->data    = false;
                    $respond->message = 'Size record not found!';
                }

                return $respond;
            }

            /**
             * Scope like custom query function, query size based 
             * on given field and field value.
             * @param String $field
             * @param String $value 
             * @return ObjectRespond [ data: data_result, message: result_message ]
             */
            public static function scopeLike( $field, $value ){
                $respond = (object)[];
                $field = strtolower($field);

                try {
                    $size = Size::where($field, 'LIKE', '%'.$value.'%')->get();
                    $respond->data = $size;
                    $respond->message = 'Sucessful getting size record by '.$field;
                } catch( ModelNotFoundException | Exception $ex ) {
                    $respond->data    = false;
                    $respond->message = 'Problem occured while trying to search size by '.$field.', please try again!';
                }

                return $respond;
            }
        // Size Helper Functions [END]

    /**
     * #####################
     *     Relationships
     * #####################
     */
        
}
