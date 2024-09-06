<?php
namespace App\Traits;

use Carbon\Carbon;

trait ResponseMessage{

    public function track_data($update_id=null,$collection){
        $created_by = $updated_by = auth()->user()->name;
        $created_at = $updated_at = Carbon::now();
        return $update_id != '' ? $collection->merge(compact('updated_by','updated_at'))
                : $collection->merge(compact('created_by','created_at'));
    }

    public function store_message($result,$update_id=null){
        return $result ? ['status'=>'success','message'=> !empty($update_id) ? 'Data has been updated successfully' : 'Data has been saved successfully']
            : ['status'=>'error','message'=> !empty($update_id) ? 'Failed to update data' : 'Falied to save data'];
    }

    public function status_message($result){
        return $result ? ['status'=>'success','message'=>'Status has been changed successfully']
                : ['status'=>'error','message'=>'Failed to change status'];
    }

    protected function delete_message($result){
        return $result ? ['status'=>'success','message'=> 'Data has been deleted successfully']
        : ['status'=>'error','message'=> 'Failed to delete data'];
    }
    protected function bulk_delete_message($result){
        return $result ? ['status'=>'success','message'=> 'Selected data has been deleted successfull']
        : ['status'=>'error','message'=> 'Failed to delete selected data'];
    }

    public function data_message($data){
        return $data ? $data : ['status'=>'error','message'=>'No data found'];;
    }

}
