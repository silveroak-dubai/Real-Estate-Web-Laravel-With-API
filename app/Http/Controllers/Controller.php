<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function set_page_data($siteTitle,$title=NULL){
        return view()->share(['siteTitle'=>$siteTitle,'title'=>$title]);
    }

    protected function response_json($status='success',$message=null,$data=null,$response_code=200)
    {
        return response()->json([
            'status'        => $status,
            'message'       => $message,
            'data'          => $data,
            'response_code' => $response_code
        ]);
    }

    protected function unauthorized_access_blocked()
    {
        return redirect('unauthorized');
    }
}
