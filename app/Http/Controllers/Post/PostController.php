<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Category;
use App\Models\Post;
use App\Traits\ResponseMessage;
use App\Traits\UploadAble;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('blog-access')) {
            if($request->ajax()){

                $getData = Post::orderBy('id','desc');
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
                        return table_image(BLOG_PATH,$row->feature_image,$row->slug);
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('published_date', function($row){
                        return dateFormat($row->published_date);
                    })
                    ->addColumn('visibility', function($row){
                        return VISIBILITY[$row->visibility] ?? '';
                    })
                    ->addColumn('status', function($row){
                        if(permission('blog-status')){
                            return POST_STATUS[$row->status];
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
                            // $action .= '<a href="'.route('app.posts.show',$row->id).'" type="button" class="btn-style btn-style-view view_data ms-1" data-id="' . $row->id . '"><i class="fa fa-eye"></i></a>';
                        }
                        if(permission('blog-edit')){
                            $action .= '<a href="'.route('app.posts.edit',$row->id).'" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
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

            $this->set_page_data('Post List','Post List');
            return view('blog.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function create(){
        if(permission('blog-create')){
            $data['categories'] = Category::active()->latest()->pluck('name','id');

            $this->set_page_data('New Blog','New Blog');
            return view('blog.create',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function store(BlogRequest $request){
        if(permission('blog-create') || permission('blog-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection    = collect($request->validated());
                    $created_at    = $updated_at = Carbon::now();
                    $created_by    = $updated_by = auth()->user()->name;
                    $feature_image = $request->old_feature_image;
                    $author_id     = auth()->user()->id;
                    if($request->hasFile('feature_image')){
                        if(!empty($request->old_feature_image)){
                            $this->delete_file($request->old_feature_image,BLOG_PATH);
                        }
                        $feature_image = $this->upload_file($request->file('feature_image'),BLOG_PATH);
                    }

                    if($request->update_id){
                        $collection = $collection->merge(compact('author_id','feature_image','updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('author_id','feature_image','created_by','created_at'));
                    }

                    $result = Post::updateOrCreate(['id'=>$request->update_id],$collection->all());
                    $result->categories()->sync($request->category);
                    DB::commit();
                    return $this->store_message($result,$request->update_id,'Post');
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
            $data['edit'] = Post::with('categories')->findOrFail($id);
            $data['categories'] = Category::active()->latest()->pluck('name','id');

            $data['selectedCategories'] = $data['edit']->categories->pluck('id')->toArray();

            $this->set_page_data('Edit User','Edit User');
            return view('blog.edit',$data);
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
                $result = Post::find($request->id);
                if($result){
                    if(!empty($result->feature_image)){
                        $this->delete_file($result->feature_image,BLOG_PATH);
                    }
                    $result->delete();
                    return $this->delete_message($result,'Post');
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
                $result = Post::whereIn('id',$request->ids)->get('feature_image');
                if($result){
                    foreach($result as $value){
                        if(!empty($value->feature_image)){
                            $this->delete_file($value->feature_image,BLOG_PATH);
                        }
                    }
                    Post::destroy($request->ids);
                    return $this->bulk_delete_message($result,'Post');
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

}
