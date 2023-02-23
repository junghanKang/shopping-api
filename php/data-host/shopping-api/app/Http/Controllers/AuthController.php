<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z가-힣\s]+$/u'],
            'nickname' => ['required', 'string', 'max:30', 'regex:/^[a-z\s]+$/'],
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/'
            ],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $password = Hash::make($request->input('password'));

        $user = DB::table('users')->insertGetId([
            'name' => $request->input('name'),
            'nickname' => $request->input('nickname'),
            'password' => $password,
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender', ''),
        ]);

        if ($user) {
            return response()->json(['message' => 'User registered successfully'], 201);
        }

        return response()->json(['message' => 'Failed to register user'], 500);
    }

    public function login(Request $request)
    {
    }

    public function logout(Request $request)
    {
    }
}
