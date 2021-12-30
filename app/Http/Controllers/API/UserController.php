<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'     => ['required', 'string', 'max:225'],
                'username' => ['required', 'string', 'max:225', 'unique:users'],
                'email'    => ['required', 'string', 'email', 'max:225', 'unique:users'],
                'phone'    => ['nullable', 'string', 'max:225'],
                'password' => ['required', 'string', new Password(8)],
            ]);

            User::create([
                'name'         => $request->name,
                'username'     => $request->username,
                'email'        => $request->email,
                'phone_number' => $request->phone,
                'password'     => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success(
                [
                    'access_token' => $tokenResult,
                    'token_type'   => 'Bearer',
                    'user'         => $user,        
                ], 
                'User Registered');
        } catch (Exception $err) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error'   => $err,
                ], 
                'Authentication failed', 
                500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email','password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message'=> 'Unauthorized',
                ], 'Authentiocation Failed', 500);
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success(
                [
                    'access_token' => $tokenResult,
                    'token_type'   => 'Bearer',
                    'user'         => $user,        
                ], 
                'Authenticated');
        } catch (Exception $err) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error'   => $err,
                ], 
                'Authentication failed', 
                500);
        }
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success(
            $request->user(), 
            'Data Profile User berhasil diambil'
        );
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name'     => ['required', 'string', 'max:225'],
                'username' => ['required', 'string', 'max:225', 'unique:users'],
                'email'    => ['required', 'string', 'email', 'max:225', 'unique:users'],
                'phone'    => ['nullable', 'string', 'max:225'],
            ]);

            $data = $request->all();

            $user = Auth::user();
            $user->update($data);
            return ResponseFormatter::success(
                $user, 
                'Profile Updated'
            );
            
        } catch (Exception $err) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error'   => $err,
                ], 
                'Updating Profile failed', 
                500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success(
            $token, 
            'Token Revoked'
        );
    }
}
