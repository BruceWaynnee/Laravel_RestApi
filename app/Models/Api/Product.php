<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'category_id',
        'country_of_origin',

    ];

    /**
     * ##############################
     *    Module Helper Functions
     * ##############################
     */

}
