<?php

namespace App\Http\Controllers\API;

use App\Models\FAQ;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FAQController extends Controller
{
    public function listData(){
        $faqLists = FAQ::active()->order('created_at')->select(['id','question','answer'])->get();
        if(!$faqLists->isEmpty()){
            return $this->response_json('success','FAQ data retrieved successfully',$faqLists,200);
        }

        return $this->response_json('error','FAQ data not found!',null,404);
    }

    public function show(int $id){
        $faq = FAQ::select(['id','question','answer'])->find($id);
        if($faq){
            return $this->response_json('success','FAQ single data retrieved successfully',$faq,200);
        }

        return $this->response_json('error','FAQ not found!',null,404);
    }
}
