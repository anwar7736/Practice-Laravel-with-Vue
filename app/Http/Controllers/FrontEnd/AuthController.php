<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator, Auth;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'phone' => '',
        ]);
        

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $inputs = $req->only(['name', 'email', 'password', 'phone']);
        try
        {
            if($image = $req->image)
            {
                $new_name = rand().'.'.$image->extension();
                $image->move(public_path('images/users'), $new_name);
                $inputs['image'] = $new_name;
            }

            $user = User::create($inputs);
            $data = $this->generate_Token($user);
            return response()->json([$data],200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }

    }    

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);
        

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        
        $inputs = $req->only(['email', 'password']);
        try
        {
            if(Auth::attempt($inputs))
            {

                $data = $this->generate_Token(Auth::user());
                return response()->json([$data],200);
            }
            else {
                $data['error'] = 'Invalid email or password';
                return response()->json([$data],200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(['Something went wrong!'], 421);
        }
    }    

    public function generate_Token($user)
    {
        Auth::login($user);
        $data['user_info'] = $user;
        $data['access_token'] = $user->createToken('DFDERE6545461AFDSF')->accessToken;
        return $data;
    }

    public function logout(Request $req)
    {
        auth()->user()->token()->revoke();
        return response()->json(['msg' => 'Logout Success'], 200);

    }
}
