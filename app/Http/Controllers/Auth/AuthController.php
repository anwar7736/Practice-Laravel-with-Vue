<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Utils\Util;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validations = [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'min:11', 'max:14', 'unique:users,phone'],
            'password' => ['required','min:4', 'confirmed'],

        ];

        $rules = [
            '*.required' => 'This field is required!',
            'email.unique' => "Email address aready exists in our database!",
            'phone.unique' => "Phone number aready exists in our database!",
        ];

        $validator = Validator::make($request->all(), $validations, $rules);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create($validator->validated());
        $data['access_token'] = $this->generateAccessToken($user);
        $data['user'] = $user;
        $data['message'] = 'Registration successfully';

        return response()->json($data, 200);

    }
    
    public function login(Request $request)
    {
        $validations = [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],

        ];

        $rules = [
            '*.required' => 'This field is required!',
            'email.exists' => "Email address doesn't exists in our database!",
        ];

        $validator = Validator::make($request->all(), $validations, $rules);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        if(Auth::attempt($validator->validated()))
        {
            $user = Auth::user();
            $data['access_token'] = $this->generateAccessToken($user);
            $data['user'] = $user;

            return response()->json($data, 200);
        }

        $data['invalid'] = 'Email address or password is incorrect!';

        return response()->json([
            'errors' => $data,
        ], 422);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->token()->revoke();

        return response()->json([
            'status' => 200,
            'message' => 'Logout Success',
        ], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $validations = [
            'name' => ['required'],
            'phone' => ['required', 'min:11', 'max:14', 'unique:users,phone,'.$id],
            'image' => ['mimes:jpg,jpeg,png,gif,svg'],
            'password' => ['confirmed'],

        ];

        $rules = [
            '*.required' => 'This field is required!',
            'phone.unique' => "Phone number aready exists in our database!",
        ];

        $validator = Validator::make($request->all(), $validations, $rules);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['name', 'phone', 'password']);

        $user = User::findOrFail($id);

        if(!empty($request->image))
        {
            Util::deleteFile('users', $user->image);

            $data['image'] = Util::uploadFile('users', $request->image);
        }        
        
        if(!empty($request->old_password))
        {
           if(!Hash::check($request->old_password, $user->password))
           {
                return response()->json([
                    'status' => 422,
                    'message' => "Old password doesn't matched!",
                ], 422);
            }

        }

        $user->update($data);

        $data = [];
        $data['message'] = 'Profile updated successfully';
        $data['user'] = $user;
        
        return response()->json($data, 200);
    }

    public function generateAccessToken($user)
    {
        return $user->createToken(Str::random(10))->accessToken;
    }

    public function unauthenticate()
    {
        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized action.',
        ], 401);
    }
}
