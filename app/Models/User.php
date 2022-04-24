<?php

namespace App\Models;

use Exception;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ##############################
     *    Module Helper Functions
     * ##############################
     */

        // User Helper Functions [BEGIN]
            /**
             * Get user record by given email parameter from database.
             * @param String $email
             * @return Respond [ data: data_restul, message: result_message ]
             */
            public static function getUserByEmail( $email ){
                $respond = (object)[];
                $email = strtolower( $email );

                try {
                    $user = User::where('email', $email)->first();
                    $respond->data    = $user;
                    $respond->message = 'User record found';
                } catch( ModelNotFoundException | Exception $ex ) {
                    $respond->data = false;
                    $respond->message = 'Given user email does not match any record on our database!';
                }

                return $respond;
            }
        // User Helper Functions [BEGIN]

}
