<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function listData(){
        $imagePath = api_image_path(OUR_ACHIEVEMENT_PATH); // for api call
        $ourAchivements = Achievement::active()
            ->order('created_at')
            ->select(['id', 'alt_text', DB::raw("CONCAT('$imagePath', image) as image")])
            ->get();
        if(!$ourAchivements->isEmpty()){
            return $this->response_json('success','Achievement data retrieved successfully',$ourAchivements,200);
        }

        return $this->response_json('error','Achievement data not found!',null,404);
    }

    public function show(int $id){
        $imagePath = api_image_path(OUR_ACHIEVEMENT_PATH); // for api call
        $ourAchivement = Achievement::select(['id','alt_text',DB::raw("CONCAT('$imagePath', image) as image")])->find($id);
        if($ourAchivement){
            return $this->response_json('success','Achievement single data retrieved successfully',$ourAchivement,200);
        }

        return $this->response_json('error','Achievement not found!',null,404);
    }
}
