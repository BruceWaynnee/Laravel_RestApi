<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    /**
     * Table name.
     * @var String
     */
    protected $table = 'colors';

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
     * #####################
     *     Relationships
     * #####################
     */
    
}
