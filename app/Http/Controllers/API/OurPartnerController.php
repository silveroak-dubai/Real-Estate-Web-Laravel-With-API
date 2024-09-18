<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OurPartner;

class OurPartnerController extends Controller
{
    public function listData(){
        $imagePath = api_image_path(OUR_PARTNER_PATH); // for api call
        $ourPartners = OurPartner::active()
            ->order('created_at')
            ->select(['id', 'alt_text', DB::raw("CONCAT('$imagePath', image) as image")])
            ->get();
        if(!$ourPartners->isEmpty()){
            return $this->response_json('success','Our partner data retrieved successfully',$ourPartners,200);
        }

        return $this->response_json('error','Our partner data not found!',null,404);
    }

    public function show(int $id){
        $imagePath = api_image_path(OUR_PARTNER_PATH); // for api call
        $ourPartner = OurPartner::select(['id','alt_text',DB::raw("CONCAT('$imagePath', image) as image")])->find($id);
        if($ourPartner){
            return $this->response_json('success','Our partner single data retrieved successfully',$ourPartner,200);
        }

        return $this->response_json('error','Our partner not found!',null,404);
    }
}
