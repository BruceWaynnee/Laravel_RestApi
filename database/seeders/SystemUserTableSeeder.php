<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\Models\User;

class SystemUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $systemUsers = [
            // default admin
            [
                'name'              => env('SYSTEM_ADMIN'),
                'email'             => env('ADMIN_EMAIL'),
                'email_verified_at' => Carbon::now(),
                'password'          => bcrypt(env('ADMIN_PASSWORD')),
            ],
            // 
        ];

        foreach( $systemUsers as $systemUser ){
            User::create($systemUser);
        }
    }
}
