<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use ResponseMessage;

    public function index(Request $request){
        if (permission('blog-access')) {
            if($request->ajax()){

                $getData = Category::orderBy('id','desc');
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
                        if(permission('blog-active')){
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
                        if(permission('blog-edit')){
                        $action .= '<button type="button" data-id="' . $row->id . '" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>';
                        }
                        if(permission('blog-delete')){
                        $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','status'])
                    ->make(true);
            }

            $this->set_page_data('Category List','Category List');
            return view('blog.category.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function storeOrUpdate(CategoryRequest $request){
        if ($request->ajax()) {
            if (permission('blog-create') || permission('blog-edit')) {
                $collection = collect($request->validated());
                $created_at = $updated_at = Carbon::now();
                $created_by = $updated_by = Auth::user()->name;
                $slug       = str()->slug($request->name,'-');
                if ($request->update_id) {
                    $collection = $collection->merge(compact('slug','updated_by','updated_at'));
                }else{
                    $collection = $collection->merge(compact('slug','created_by','created_at'));
                }

                $result = Category::updateOrCreate(['id'=>$request->update_id],$collection->all());
                if($result){
                    return $this->store_message($result,$request->update_id);
                }else{
                    return $this->response_json('error','Data Cannot Save',null,204);
                }
            }else{
                return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
            }
        }
    }

    public function edit(Request $request){
        if ($request->ajax()) {
            if (permission('blog-edit')) {
                $data = Category::find($request->id);
                if($data->count()){
                    return $this->response_json('success',null,$data,201);
                }else{
                    return $this->response_json('error','No Data Found',null,204);
                }
            }else{
                return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
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
            if(permission('blog-delete')){
                $result = Category::find($request->id);
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
            if(permission('blog-bulk-delete')){
                $result = Category::destroy($request->ids);
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
}
