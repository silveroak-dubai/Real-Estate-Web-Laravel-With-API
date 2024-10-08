<?php

namespace App\Http\Controllers\OurTeam;

use App\Http\Controllers\Controller;
use App\Http\Requests\OurTeamRequest;
use App\Models\Department;
use App\Models\OurTeam;
use App\Models\TeamLanguage;
use App\Models\TeamSpecialized;
use App\Traits\ResponseMessage;
use App\Traits\UploadAble;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OurTeamController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('our-team-access')) {
            if($request->ajax()){

                $getData = OurTeam::orderBy('id','desc');
                return DataTables::eloquent($getData)
                    ->addIndexColumn()
                    ->filter(function ($query) use ($request) {
                        if (!empty($request->search)) {
                            $query->where('full_name', 'LIKE', "%$request->search%")
                                ->orWhere('position', 'LIKE', "%$request->search%");
                        }
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('image', function($row){
                        return table_image(OUR_TEAM_IMAGE_PATH,$row->image,$row->name);
                    })
                    ->addColumn('status', function($row){
                        if(permission('our-team-status')){
                            return POST_STATUS_LABEL[$row->status];
                        }
                    })
                    ->addColumn('bulk_check', function($row){
                        if(permission('our-team-bulk-delete')){
                            return table_checkbox($row->id);
                        }
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        if(permission('our-team-edit')){
                        $action .= '<a href="'.route('app.our-teams.edit',$row->id).'" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                        }
                        if(permission('our-team-delete')){
                        $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','image','status'])
                    ->make(true);
            }

            $this->set_page_data('Our Team List','Our Team List');
            return view('our-team.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function create(){
        if(permission('our-team-create')){
            $data['departments']  = Department::active()->orderBy('name','asc')->pluck('name','id');
            $data['languages']    = TeamLanguage::active()->orderBy('name','asc')->pluck('name','id');
            $data['specializeds'] = TeamSpecialized::active()->orderBy('name','asc')->pluck('name','id');

            $this->set_page_data('New Our Team','New Our Team');
            return view('our-team.create',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function store(OurTeamRequest $request){
        if(permission('our-team-create') || permission('our-team-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection = collect($request->validated());
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;
                    $image = $request->old_image;
                    if($request->hasFile('image')){
                        $image = $this->upload_file($request->file('image'),OUR_TEAM_IMAGE_PATH);
                        if(!empty($request->old_image)){
                            $this->delete_file($request->old_image,OUR_TEAM_IMAGE_PATH);
                        }
                    }

                    if($request->update_id){
                        $collection = $collection->merge(compact('image','updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('image','created_by','created_at'));
                    }

                    $result = OurTeam::updateOrCreate(['id'=>$request->update_id],$collection->all())->languages()->sync($request->languages);
                    DB::commit();
                    if($result){
                        return $this->store_message($result,$request->update_id);
                    }else{
                        return $this->response_json('error','Something went wrong!');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->response_json('error',$e->getMessage());
                }
            }
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function edit(int $id){
        if(permission('our-team-edit')){
            $data['edit']         = OurTeam::with('languages')->findOrFail($id);
            $data['departments']  = Department::active()->orderBy('name','asc')->pluck('name','id');
            $data['languages']    = TeamLanguage::active()->orderBy('name','asc')->pluck('name','id');
            $data['specializeds'] = TeamSpecialized::active()->orderBy('name','asc')->pluck('name','id');

            $this->set_page_data('Edit Our Team','Edit Our Team');
            return view('our-team.edit',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function show(int $id){
        if(permission('our-team-view')){
            $data['view'] = OurTeam::findOrFail($id);
            $this->set_page_data('View Our Team','View Our Team ('.$data['view']->name.')');
            return view('our-team.view',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    /**
     * spacified delete resource
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){
        if ($request->ajax()) {
            if(permission('our-team-delete')){
                $result = OurTeam::find($request->id);
                if($result){
                    if ($result->image) {
                        $this->delete_file($result->image,OUR_TEAM_IMAGE_PATH);
                    }

                    $result->delete();
                    return $this->delete_message($result);
                }else{
                    return $this->response_json('error','Data Cannot Delete',null,204);
                }
            }else{
                return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
            }
        }else{
            return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
        }
    }

    /**
     * multiple destroy resource
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request){
        if ($request->ajax()) {
            if(permission('our-team-bulk-delete')){
                $result = OurTeam::destroy($request->ids);
                if($result){
                    return $this->bulk_delete_message($result);
                }else{
                    return $this->response_json('error','Data Cannot Delete',null,204);
                }
            }else{
                return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
            }
        }else{
            return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
        }
    }

    /**
     * spacified status update
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request){
        if ($request->ajax()) {
            if(permission('our-team-status')){
                $result = OurTeam::find($request->id);
                if ($result) {
                    $result->update(['status'=>$request->status]);
                    return $this->status_message($result);
                }else{
                    return $this->response_json('error','Failed to change status',null,204);
                }
            }else{
                return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
            }
        }
    }
}
