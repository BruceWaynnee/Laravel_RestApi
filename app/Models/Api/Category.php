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
        'description',

    ];

    /**
     * #####################
     *     Relationships
     * #####################
     */
        /**
         * One category to many product relationship.
         * @return App\Models\Api\Product
         */
        public function products(){
            return $this->hasMany(
                Product::class,
                'category_id',
            );
        }
}
