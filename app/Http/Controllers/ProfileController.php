<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordFormRequest;
use App\Http\Requests\ProfileFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfileForm(){
        $data['user'] = Auth::user();

        $this->set_page_data('Profile','Profile');
        return view('user.profile',$data);
    }

    public function profileUpdate(ProfileFormRequest $request){
        if($request->ajax()){

        }
    }

    public function passwordUpdate(PasswordFormRequest $request){
        if($request->ajax()){

        }
    }
}
