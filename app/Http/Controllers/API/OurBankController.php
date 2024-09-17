<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OurBank;
use Illuminate\Http\Request;

class OurBankController extends Controller
{
    public function listData(){
        $ourBanks = OurBank::active()->order('created_at')->select(['id','alt_text','image'])->get();
        if(!$ourBanks->isEmpty()){
            return $this->response_json('success','Our bank data retrieved successfully',$ourBanks,200);
        }

        return $this->response_json('error','Our bank data not found!',null,404);
    }

    public function show(int $id){
        $ourBank = OurBank::select(['id','alt_text','image'])->find($id);
        if($ourBank){
            return $this->response_json('success','Our bank single data retrieved successfully',$ourBank,200);
        }

        return $this->response_json('error','Our bank not found!',null,404);
    }
}
