<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'unique:users,phone', 'string'],
            'document_number' => ['required', 'string', 'digits:10'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        User::create($request->all());

        return response(null, 204);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        if ($user = User::where('phone', $request->phone)->first()) {
            if ($user->password == $request->password) {
                return response()->json([
                    'data' => [
                        'token' => $user->generateToken()
                    ]
                ]);
            }
        }

        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'errors' => [
                    'phone' => ['phone or password incorrect']
                ]
            ]
        ]);
    }
}
