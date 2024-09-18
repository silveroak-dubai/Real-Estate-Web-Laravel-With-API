<?php

namespace App\Http\Controllers\API;

use App\Models\OurBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OurBankController extends Controller
{
    public function listData(){
        $imagePath = api_image_path(OUR_BANKS_PATH); // for api call
        $ourBanks = OurBank::active()
            ->order('created_at')
            ->select(['id', 'alt_text', DB::raw("CONCAT('$imagePath', image) as image")])
            ->get();
        if(!$ourBanks->isEmpty()){
            return $this->response_json('success','Our bank data retrieved successfully',$ourBanks,200);
        }

        return $this->response_json('error','Our bank data not found!',null,404);
    }

    public function show(int $id){
        $imagePath = api_image_path(OUR_BANKS_PATH); // for api call
        $ourBank = OurBank::select(['id','alt_text',DB::raw("CONCAT('$imagePath', image) as image")])->find($id);
        if($ourBank){
            return $this->response_json('success','Our bank single data retrieved successfully',$ourBank,200);
        }

        return $this->response_json('error','Our bank not found!',null,404);
    }
}
