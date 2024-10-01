<?php

namespace App\Http\Controllers\OurTeam;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Models\OurTeam;
use App\Traits\ResponseMessage;
use App\Traits\UploadAble;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('department-access')) {
            if($request->ajax()){

                $getData = Department::with('ourTeams')->orderBy('id','desc');
                return DataTables::eloquent($getData)
                    ->addIndexColumn()
                    ->filter(function ($query) use ($request) {
                        if (!empty($request->search)) {
                            $query->where('name', 'LIKE', "%$request->search%");
                        }
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('status', function($row){
                        if(permission('department-status')){
                            return change_status($row->id,$row->status,$row->name);
                        }
                    })
                    ->addColumn('bulk_check', function($row){
                        if(permission('department-bulk-delete')){
                            return table_checkbox($row->id);
                        }
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        if($row->ourTeams->isNotEmpty()){
                        $action .= '<a href="'.route('app.departments.ordering.index',$row->id).'" '.tooltip('Team Member Ordering').' class="btn-style btn-style-view ms-1"><i class="fa fa-sort-amount-asc"></i></a>';
                        }

                        if(permission('department-edit')){
                        $action .= '<button type="button" '.tooltip('Edit').' class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>';
                        }

                        if(permission('department-delete')){
                        $action .= '<button type="button" '.tooltip('Delete').' class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','image','status'])
                    ->make(true);
            }

            $this->set_page_data('Department List','Department List');
            return view('our-team.department.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function deptOrderForm(int $id){
        $data = Department::with('ourTeams')->findOrFail($id);
        $this->set_page_data('Team Member Order','Team Member Order');
        return view('our-team.ordering', compact('data'));
    }

    public function deptOrder(Request $request){
        if($request->ajax()){
            try {
                $order = $request->order;
                foreach ($order as $key => $id) {
                    $item = OurTeam::find($id);
                    $item->ordering = $key + 1;
                    $item->save();
                }

                return response()->json(['status'=>'success','message'=>'Status order successfull.']);
            } catch (\Exception $e) {
                return response()->json(['status'=>'error','message'=>'Something went wrong!']);
            }
        }
    }

    public function storeOrUpdate(DepartmentRequest $request){
        if(permission('department-create') || permission('department-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection = collect($request->validated());
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;
                    $slug       = Str::slug($request->slug,'-');

                    if($request->update_id){
                        $collection = $collection->merge(compact('slug','updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('slug','created_by','created_at'));
                    }

                    Department::updateOrCreate(['id'=>$request->update_id],$collection->all());
                    DB::commit();
                    return $this->response_json('success','Department has been saved succesfull.');
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
            if(permission('department-edit')){
                $data = Department::find($request->id);
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
            if(permission('department-delete')){
                $result = Department::find($request->id);
                if($result){
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
            if(permission('department-bulk-delete')){
                $result = Department::destroy($request->ids);
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
            if(permission('department-status')){
                $result = Department::find($request->id);
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
