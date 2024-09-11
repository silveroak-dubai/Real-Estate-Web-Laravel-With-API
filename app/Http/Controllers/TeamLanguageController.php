<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OurPartner;
use App\Traits\UploadAble;
use App\Models\TeamLanguage;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OurPartnerRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TeamLanguageRequest;

class TeamLanguageController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('team-language-access')) {
            if($request->ajax()){

                $getData = TeamLanguage::orderBy('id','desc');
                return DataTables::eloquent($getData)
                    ->addIndexColumn()
                    ->filter(function ($query) use ($request) {
                        if (!empty($request->search)) {
                            $query->where('name', 'LIKE', "%$request->search%")
                                ->orWhere('email', 'LIKE', "%$request->search%")
                                ->orWhere('mobile_no', 'LIKE', "%$request->search%");
                        }
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('image', function($row){
                        return table_image(OUR_TEAM_LANGUAGE_PATH,$row->image,$row->name);
                    })
                    ->addColumn('status', function($row){
                        if(permission('team-language-status')){
                            return change_status($row->id,$row->status,$row->name);
                        }
                    })
                    ->addColumn('bulk_check', function($row){
                        if(permission('team-language-bulk-delete')){
                            return table_checkbox($row->id);
                        }
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        // if(permission('team-language-view')){
                        // $action .= '<a href="'.route('app.team-language.show',$row->id).'" type="button" class="btn-style btn-style-view view_data ms-1" data-id="' . $row->id . '"><i class="fa fa-eye"></i></a>';
                        // }
                        if(permission('team-language-edit')){
                        $action .= '<a href="'.route('app.team-languages.edit',$row->id).'" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                        }
                        if(permission('team-language-delete')){
                        $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','image','status'])
                    ->make(true);
            }

            $this->set_page_data('Team Language List','Team Language List');
            return view('team-language.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function create(){
        if(permission('team-language-create')){
            $this->set_page_data('New Team Language','New Team Language');
            return view('team-language.create');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function store(TeamLanguageRequest $request){
        if(permission('team-language-create') || permission('team-language-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection = collect($request->validated());
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;

                    $image = $request->old_image;
                    if($request->hasFile('image')){
                        $image = $this->upload_file($request->file('image'),OUR_TEAM_LANGUAGE_PATH);
                        if(!empty($request->old_image)){
                            $this->delete_file($request->old_image,OUR_TEAM_LANGUAGE_PATH);
                        }
                    }

                    if($request->update_id){
                        $collection = $collection->merge(compact('updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('created_by','created_at'));
                    }

                    TeamLanguage::updateOrCreate(['id'=>$request->update_id],$collection->all());
                    DB::commit();
                    return $this->response_json('success','Team Language has been saved succesfull.');
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
        if(permission('team-language-edit')){
            $data['edit'] = TeamLanguage::findOrFail($id);
            $this->set_page_data('Edit Team Language','Edit Team Language');
            return view('team-language.edit',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function show(int $id){
        if(permission('team-language-view')){
            $data['view'] = TeamLanguage::findOrFail($id);
            $this->set_page_data('View Team Language','View Team Language ('.$data['view']->name.')');
            return view('team-language.view',$data);
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
            if(permission('team-language-delete')){
                $result = TeamLanguage::find($request->id);
                if($result){
                    if ($result->image) {
                        $this->delete_file($result->image,OUR_TEAM_LANGUAGE_PATH);
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
            if(permission('team-language-bulk-delete')){
                $result = TeamLanguage::destroy($request->ids);
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
            if(permission('team-language-status')){
                $result = TeamLanguage::find($request->id);
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

