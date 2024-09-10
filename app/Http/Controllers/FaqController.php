<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Faq;
use App\Models\OurBank;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use App\Http\Requests\FaqRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OurBankRequest;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    use UploadAble, ResponseMessage;

    public function index(Request $request){
        if (permission('faq-access')) {
            if($request->ajax()){

                $getData = Faq::orderBy('id','desc');
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
                    ->addColumn('status', function($row){
                        if(permission('faq-active')){
                            return change_status($row->id,$row->status,$row->name);
                        }
                    })
                    ->addColumn('bulk_check', function($row){
                        if(permission('faq-bulk-delete')){
                            return table_checkbox($row->id);
                        }
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        // if(permission('faq-view')){
                        // $action .= '<a href="'.route('app.faqs.show',$row->id).'" type="button" class="btn-style btn-style-view view_data ms-1" data-id="' . $row->id . '"><i class="fa fa-eye"></i></a>';
                        // }
                        if(permission('faq-edit')){
                        $action .= '<a href="'.route('app.faqs.edit',$row->id).'" class="btn-style btn-style-edit edit_data ms-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></a>';
                        }
                        if(permission('faq-delete')){
                        $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['bulk_check','status','action','image','status'])
                    ->make(true);
            }

            $this->set_page_data('Faq List','Faq List');
            return view('faqs.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function create(){
        if(permission('faq-create')){
            $this->set_page_data('New Faq','New Faq');
            return view('faqs.create');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function store(FaqRequest $request){
        if(permission('faq-create') || permission('faq-edit')){
            if ($request->ajax()) {
                DB::beginTransaction();
                try {
                    $collection = collect($request->validated());
                    $created_at = $updated_at = Carbon::now();
                    $created_by = $updated_by = auth()->user()->name;

                    if($request->update_id){
                        $collection = $collection->merge(compact('updated_by','updated_at'));
                    }else{
                        $collection = $collection->merge(compact('created_by','created_at'));
                    }

                    Faq::updateOrCreate(['id'=>$request->update_id],$collection->all());
                    DB::commit();
                    return $this->response_json('success','Faq has been saved succesfull.');
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
        if(permission('faq-edit')){
            $data['edit'] = Faq::findOrFail($id);
            $this->set_page_data('Edit Faq','Edit Faq');
            return view('faqs.edit',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function show(int $id){
        if(permission('faq-view')){
            $data['view'] = Faq::findOrFail($id);
            $this->set_page_data('View Faq','View Faq ('.$data['view']->name.')');
            return view('faqs.view',$data);
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
            if(permission('faq-delete')){
                $result = Faq::find($request->id);
                if($result){
                    if ($result->image) {
                        $this->delete_file($result->image,OUR_BANKS_PATH);
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
            if(permission('faq-bulk-delete')){
                $result = Faq::destroy($request->ids);
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
            if(permission('faq-active')){
                $result = Faq::find($request->id);
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

