<?php

namespace App\Http\Controllers;

use App\Models\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register new user account and return an access token 
     * response back on successfully registred.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        // validate user request
        $fields = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        // create data
        try {
            DB::beginTransaction();

            // register new user record
            $user = User::create([
                'name'     => $fields['name'],
                'email'    => strtolower( $fields['email'] ),
                'password' => bcrypt( $fields['password'] ),
            ]);

            // generate user token
            $token = $user->createToken('laravelrestapitoken')->plainTextToken;

            $response = [
                'code'    => 201,
                'status'  => 'OK',
                'data'    => true,
                'user'    => $user,
                'token'   => $token,
                'message' => 'Successfully registered new user with access token',
            ];
        } catch ( Exception $ex ) {
            DB::rollBack();

            $response = [
                'code'           => 409,
                'status'         => 'Error',
                'data'           => false,
                'message'        => 'Fail to register new user account',
                'detail message' => $ex->getMessage(),
            ];
        }
        DB::commit();

        return response($response, $response['code']);
    }

    /**
     * Log the user in.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        // validate user request
        $fields = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        // get user by email
        $user = User::getUserByEmail( $fields['email'] );
        if( !$user->data ) {
            return response()->json($user->message, 404);
        }
        $user = $user->data;

        // check password
        if( !Hash::check( $fields['password'], $user->password ) ){
            return response([
                'message' => 'Bad Credentials!'
            ], 401);
        }

        // generate user token
        $token = $user->createToken('laravelrestapitoken')->plainTextToken;

        $response = [
            'code'    => 201,
            'status'  => 'OK',
            'data'    => true,
            'user'    => $user,
            'token'   => $token,
            'message' => 'Successfully logged in the user with access token',
        ];

        return response($response, $response['code']);
    }

    /**
     * Log the current logged in user out from the database
     * by deleting the token that store inside database.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response([
            'status' => 'OK',
            'message' => 'The user is logged out',
        ], 200);
    }
}
