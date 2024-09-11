<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Module;
use App\Models\Permission;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('user-access')) {
            if($request->ajax()){

                $getData = User::orderBy('id','desc');
                return DataTables::eloquent($getData)
                    ->addIndexColumn()
                    ->filter(function ($query) use ($request) {
                        if (!empty($request->search)) {
                            $query->where('name', 'LIKE', "%$request->search%")
                                ->orWhere('email', 'LIKE', "%$request->search%")
                                ->orWhere('mobile_no', 'LIKE', "%$request->search%");
                        }
                    })
                    ->addColumn('name_data', function($row){
                        return $row->name;
                    })
                    ->addColumn('gender', function($row){
                        return GENDER[$row->gender];
                    })
                    ->addColumn('image', function($row){
                        return table_image(USER_AVATAR_PATH,$row->avatar,$row->name);
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('status', function($row){
                        if(permission('user-status')){
                            return change_status($row->id,$row->is_active,$row->name);
                        }
                    })
                    ->addColumn('bulk_check', function($row){
                        if(permission('user-bulk-delete')){
                            return table_checkbox($row->id);
                        }
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        if(permission('user-view')){
                            $action .= '<a href="'.route('app.users.show',$row->id).'" type="button" class="btn-style btn-style-view view_data ms-1" data-id="' . $row->id . '"><i class="fa fa-eye"></i></a>';
                        }
                        if(permission('user-edit')){
                            $action .= '<a href="'.route('app.users.edit',$row->id).'" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                        }
                        if(permission('user-delete')){
                            $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','image','status'])
                    ->make(true);
            }

            $this->set_page_data('Users','User List');
            return view('user.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function create(){
        if(permission('user-create')){
            $data['modules'] = Module::with('permissions')->orderBy('id','asc')->get();
            $this->set_page_data('New User','New User');
            return view('user.create',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function store(UserRequest $request){
        if(permission('user-create') || permission('user-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection = collect($request->validated())->except('permission','password');
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;
                    $password   = $request->password;
                    $image = $request->old_image;
                    if($request->hasFile('image')){
                        if(!empty($request->old_image)){
                            $this->delete_file($request->old_image,USER_AVATAR_PATH);
                        }
                        $image = $this->upload_file($request->file('image'),USER_AVATAR_PATH);
                    }

                    if($request->update_id){
                        $collection = $collection->merge(compact('image','updated_by','updated_at','password'));
                    }else{
                        $collection = $collection->merge(compact('image','created_by','created_at','password'));
                    }

                    User::updateOrCreate(['id'=>$request->update_id],$collection->all())->permissions()->sync($request->permission);
                    DB::commit();
                    return $this->response_json('success','User has been saved succesfull.');
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
        if(permission('user-edit')){
            $data['edit'] = User::with('permissions')->findOrFail($id);
            $data['total_permission'] = DB::table('permissions')->count();
            $data['modules'] = Module::with('permissions')->orderBy('id','asc')->get();
            $this->set_page_data('Edit User','Edit User');
            return view('user.edit',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function show(int $id){
        if(permission('user-view')){
            $data['view'] = User::with('permissions')->findOrFail($id);
            $data['modules'] = Module::with('permissions')->orderBy('id','asc')->get();
            $this->set_page_data('View User','View User ('.$data['view']->name.')');
            return view('user.view',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    /**
     * spacified user delete resource
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){
        if ($request->ajax()) {
            if(permission('user-delete')){
                $result = User::find($request->id);
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
     * multiple user destroy resource
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request){
        if ($request->ajax()) {
            if(permission('user-bulk-delete')){
                $result = User::destroy($request->ids);
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
     * spacified user status update
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request){
        if ($request->ajax()) {
            if(permission('user-status')){
                $result = User::find($request->id);
                if ($result) {
                    $result->update(['is_active'=>$request->status]);
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
