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
     * #####################
     *     Relationships
     * #####################
     */
        
}
