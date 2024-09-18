<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TeamLanguage;
use App\Models\TeamSpecialized;
use Illuminate\Http\Request;

class OurTeamController extends Controller
{
    public function languageLists(){
        $ourlanguages = TeamLanguage::active()
            ->order('name','ASC')
            ->select(['id', 'name'])
            ->get();
        if(!$ourlanguages->isEmpty()){
            return $this->response_json('success','Team member language data retrieved successfully',$ourlanguages,200);
        }

        return $this->response_json('error','Team member language data not found!',null,404);
    }

    public function specializedLists(){
        $teamMemberSpecialized = TeamSpecialized::active()
            ->order('name','ASC')
            ->select(['id', 'name'])
            ->get();
        if(!$teamMemberSpecialized->isEmpty()){
            return $this->response_json('success','Team member specialized data retrieved successfully',$teamMemberSpecialized,200);
        }

        return $this->response_json('error','Team member specialized data not found!',null,404);
    }
}
