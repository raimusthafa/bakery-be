<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Logging input
        Log::info('Login attempt', [
            'email' => $request->email
        ]);

        // set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed on login', [
                'errors' => $validator->errors()
            ]);
            return response()->json($validator->errors(), 422);
        }

        // get credentials
        $credentials = $request->only('email', 'password');

        // cek apakah user ada
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            Log::warning('Login failed - email not found', [
                'email' => $request->email
            ]);
        } else {
            Log::info('User found for login', [
                'email' => $user->email,
                'hashed_password' => $user->password
            ]);

            // tambahkan pengecekan manual password
            if (Hash::check($request->password, $user->password)) {
                Log::info('✅ Password cocok');
            } else {
                Log::warning('❌ Password tidak cocok');
            }
        }

        // attempt login via jwt
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            Log::error('Login failed - invalid credentials', [
                'email' => $request->email
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        // success
        Log::info('Login successful', [
            'email' => $request->email
        ]);

        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }
}
