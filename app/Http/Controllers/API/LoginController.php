<?php

namespace App\Http\Controllers\API;

use App\Models\API\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        // define variables
        $email    = $request->email;
        $password = $request->password;

        $user = User::where('email',$email)->first();
        if($user){
            if(!Hash::check($password, $user->password)){
                return $this->response_json('error','Password Does Not Match!',null,401);
            }else{
                // Generate token
                $data['token'] = $user->createToken($user->email)->plainTextToken;
                $user->update(['access_token'=>$data['token']]);
                return $this->response_json('success','Login Access Token',$data,200);
            }
        }else{
            return $this->response_json('error','Email Does Not Match!',null,401);
        }
    }
}
