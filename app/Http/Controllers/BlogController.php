<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Blog;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('blog-access')) {
            if($request->ajax()){

                $getData = Blog::orderBy('id','desc');
                return DataTables::eloquent($getData)
                    ->addIndexColumn()
                    ->filter(function ($query) use ($request) {
                        if (!empty($request->search)) {
                            $query->where('name', 'LIKE', "%$request->search%")
                                ->orWhere('email', 'LIKE', "%$request->search%")
                                ->orWhere('mobile_no', 'LIKE', "%$request->search%");
                        }
                    })
                    ->addColumn('image', function($row){
                        return table_image(USER_AVATAR_PATH,$row->avatar,$row->name);
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('status', function($row){
                        if(permission('blog-active')){
                            return change_status($row->id,$row->is_active,$row->name);
                        }
                    })
                    ->addColumn('bulk_check', function($row){
                        if(permission('blog-bulk-delete')){
                            return table_checkbox($row->id);
                        }
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        if(permission('blog-view')){
                        $action .= '<a href="'.route('app.users.show',$row->id).'" type="button" class="btn-style btn-style-view view_data ms-1" data-id="' . $row->id . '"><i class="fa fa-eye"></i></a>';
                        }
                        if(permission('blog-edit')){
                        $action .= '<a href="'.route('app.users.edit',$row->id).'" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                        }
                        if(permission('blog-delete')){
                        $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','image','status'])
                    ->make(true);
            }

            $this->set_page_data('Blog List','Blog List');
            return view('blog.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function create(){
        if(permission('blog-create')){
            $this->set_page_data('New Blog','New Blog');
            return view('blog.create');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function store(BlogRequest $request){
        if(permission('blog-create') || permission('blog-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection = collect($request->validated());
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;
                    $image = $request->old_image;
                    if($request->hasFile('image')){
                        $image = $this->upload_file($request->file('image'),BLOG_PATH);
                        if(!empty($request->old_image)){
                            $this->delete_file($request->old_image,BLOG_PATH);
                        }
                    }

                    if($request->update_id){
                        $collection = $collection->merge(compact('image','updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('image','created_by','created_at'));
                    }

                    Blog::updateOrCreate(['id'=>$request->update_id],$collection->all());
                    DB::commit();
                    return $this->response_json('success','Blog has been saved succesfull.');
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
        if(permission('blog-edit')){
            $data['edit'] = Blog::with('permissions')->findOrFail($id);
            $data['modules'] = Module::with('permissions')->orderBy('id','asc')->get();
            $this->set_page_data('Edit User','Edit User');
            return view('user.edit',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function show(int $id){
        if(permission('blog-view')){
            $data['view'] = Blog::with('permissions')->findOrFail($id);
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
            if(permission('blog-delete')){
                $result = Blog::find($request->id);
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
            if(permission('blog-bulk-delete')){
                $result = Blog::destroy($request->ids);
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
            if(permission('blog-active')){
                $result = Blog::find($request->id);
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
