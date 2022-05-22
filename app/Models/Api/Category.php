<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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