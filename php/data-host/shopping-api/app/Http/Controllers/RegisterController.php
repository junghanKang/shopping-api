<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function registerUser(Request $request)
    {
        $name = $request->input('name');
        $nickname = $request->input('nickname');
        $password = $request->input('password');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $gender = $request->input('gender', '');

        DB::insert(
                'insert into users (name, nickname, password, phone, email, gender) values (?, ?, ?, ?, ?, ?)',
                [$name, $nickname, $password, $phone, $email, $gender]
            );

        return response()->json(['message' => 'Request successful']);
    }
}
