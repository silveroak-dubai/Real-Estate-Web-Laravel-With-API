<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileFormRequest;
use App\Http\Requests\PasswordFormRequest;

class ProfileController extends Controller
{
    use UploadAble;

    /**
     * Auth user profile resources
     *
     * @return \Illuminate\View\View
     */
    public function showProfileForm(){
        $data['user'] = Auth::user();

        $this->set_page_data('Profile','Profile');
        return view('user.profile',$data);
    }

    /**
     * Auth user profile resource update
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profileUpdate(ProfileFormRequest $request){
        if($request->ajax()){
            $collection = collect($request->validated());
            $image = $request->old_image;
            if($request->hasFile('image')){
                if(!empty($request->old_image)){
                    $this->delete_file($request->old_image,USER_AVATAR_PATH); // old image file remove
                }
                $image = $this->upload_file($request->file('image'),USER_AVATAR_PATH); // upload new image file
            }
            $collection = $collection->merge(compact('image'));
            $result = User::find(auth()->user()->id);
            if($result){
                $result->update($collection->all());
                return $this->response_json('success','Profile Updated.',null,200);
            }else{
                return $this->response_json('error','Someting went wrong!',null,500);
            }
        }
    }

    /**
     * Auth user password resource update
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordUpdate(PasswordFormRequest $request){
        if($request->ajax()){
            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return $this->response_json('error','The current password is incorrect.',null,422);
            }

            // Update the password
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            if($user->save()){
                Auth::logout();
                return $this->response_json('success','Password updated successfull.',null,422);
            }else{
                return $this->response_json('error','Password not updated!',null,422);
            }
        }
    }
}
