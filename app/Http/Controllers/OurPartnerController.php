<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\OurPartner;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OurPartnerRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AchievementRequest;

class OurPartnerController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('our-partner-access')) {
            if($request->ajax()){

                $getData = OurPartner::orderBy('id','desc');
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
                        return table_image(OUR_PARTNER_PATH,$row->image,$row->name);
                    })
                    ->addColumn('status', function($row){
                        if(permission('our-partner-status')){
                            return change_status($row->id,$row->status,$row->name);
                        }
                    })
                    ->addColumn('bulk_check', function($row){
                        if(permission('our-partner-bulk-delete')){
                            return table_checkbox($row->id);
                        }
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        if(permission('our-partner-edit')){
                        $action .= '<button type="button" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>';
                        }
                        if(permission('our-partner-delete')){
                        $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','image','status'])
                    ->make(true);
            }

            $this->set_page_data('Our Partners List','Our Partners List');
            return view('our-partner.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }


    public function storeOrUpdate(OurPartnerRequest $request){
        if(permission('our-partner-create') || permission('our-partner-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection = collect($request->validated());
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;
                    $image = $request->old_image;
                    if($request->hasFile('image')){
                        $image = $this->upload_file($request->file('image'),OUR_PARTNER_PATH);
                        if(!empty($request->old_image)){
                            $this->delete_file($request->old_image,OUR_PARTNER_PATH);
                        }
                    }

                    if($request->update_id){
                        $collection = $collection->merge(compact('image','updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('image','created_by','created_at'));
                    }

                    OurPartner::updateOrCreate(['id'=>$request->update_id],$collection->all());
                    DB::commit();
                    return $this->response_json('success','Our partners has been saved succesfull.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return $this->response_json('error',$e->getMessage());
                }
            }
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function edit(Request $request){
        if($request->ajax()){
            if(permission('our-partner-edit')){
                $data = OurPartner::find($request->id);
                if($data->count()){
                    return $this->response_json('success',null,$data,201);
                }else{
                    return $this->response_json('error','No Data Found',null,204);
                }
            }else{
                return $this->unauthorized_access_blocked();
            }
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
            if(permission('our-partner-delete')){
                $result = OurPartner::find($request->id);
                if($result){
                    if ($result->image) {
                        $this->delete_file($result->image,OUR_PARTNER_PATH);
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
            if(permission('our-partner-bulk-delete')){
                $result = OurPartner::destroy($request->ids);
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
            if(permission('our-partner-status')){
                $result = OurPartner::find($request->id);
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

