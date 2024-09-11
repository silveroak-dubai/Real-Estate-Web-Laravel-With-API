<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Blog;
use App\Traits\UploadAble;
use Illuminate\Support\Str;
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
                        return table_image(BLOG_PATH,$row->image,$row->slug);
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('published_date', function($row){
                        return dateFormat($row->published_date);
                    })
                    ->addColumn('status', function($row){
                        if(permission('blog-status')){
                            return change_status($row->id,$row->status,$row->name);
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
                            $action .= '<a href="'.route('app.blogs.show',$row->id).'" type="button" class="btn-style btn-style-view view_data ms-1" data-id="' . $row->id . '"><i class="fa fa-eye"></i></a>';
                        }
                        if(permission('blog-edit')){
                            $action .= '<a href="'.route('app.blogs.edit',$row->id).'" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
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
                    $collection = collect($request->validated())->except('slug');
                    $slug       = str()->slug($request->slug,'-');
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;
                    $image = $request->old_image;
                    if($request->hasFile('image')){
                        if(!empty($request->old_image)){
                            $this->delete_file($request->old_image,BLOG_PATH);
                        }
                        $image = $this->upload_file($request->file('image'),BLOG_PATH);
                    }

                    if($request->update_id){
                        $collection = $collection->merge(compact('slug','image','updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('slug','image','created_by','created_at'));
                    }

                    $result = Blog::updateOrCreate(['id'=>$request->update_id],$collection->all());
                    DB::commit();
                    return $this->store_message($result,$request->update_id);
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
            $data['edit'] = Blog::findOrFail($id);
            $this->set_page_data('Edit User','Edit User');
            return view('blog.edit',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function show(int $id){
        if(permission('blog-view')){
            $data['view'] = Blog::findOrFail($id);
            $this->set_page_data('View User','View User');
            return view('blog.view',$data);
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
                    if(!empty($result->image)){
                        $this->delete_file($result->image,BLOG_PATH);
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
     * multiple user destroy resource
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request){
        if ($request->ajax()) {
            if(permission('blog-bulk-delete')){
                $result = Blog::whereIn('id',$request->ids)->get('image');
                if($result){
                    foreach($result as $value){
                        if(!empty($value->image)){
                            $this->delete_file($value->image,BLOG_PATH);
                        }
                    }
                    Blog::destroy($request->ids);
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
            if(permission('blog-status')){
                $result = Blog::find($request->id);
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
