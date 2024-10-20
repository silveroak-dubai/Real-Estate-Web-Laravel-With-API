<?php

define('STORAGE_PATH','storage/');
define('USER_AVATAR_PATH','user/');
define('LOGO_PATH','logo/');
define('BLOG_PATH','blog/');
define('OUR_BANKS_PATH','our-banks/');
define('OUR_ACHIEVEMENT_PATH','achievements/');
define('OUR_PARTNER_PATH','our-partners/');
define('TESTIMONIAL_IMAGE_PATH','testimonial/');
define('OUR_TEAM_IMAGE_PATH','our-team/');
define('GENDER',[1=>'Male',2=>'Female']);
define('ENABLED_DISABLED',[1=>'Enabled',2=>'Disabled']);
define('STATUS',[1=>'Active',2=>'Inactive']);
define('STATUS_LABEL',[
    1=>'<span class="badge badge-sm fw-normal rounded-0 bg-success">Active</span>',
    2=>'<span class="badge badge-sm fw-normal rounded-0 bg-danger">Inctive</span>'
]);
define('UNAUTORIZED_BLOCK','Unauthorized Access!');
define('TABLE_PAGE_LENGTH',15);
define('MAIL_MAILER',['smtp','sendmail','mail']);
define('MAIL_ENCRYPTION',['none'=>'null','tls'=>'tls','ssl'=>'ssl']);
define('VISIBILITY',[1=>'Public',2=>'Private']);
define('POST_STATUS',[1=>'Published',2=>'Draft',3=>'Pending']);
define('POST_STATUS_LABEL',[
    1=>'<span class="badge badge-sm fw-normal rounded-0 bg-success">Published</span>',
    2=>'<span class="badge badge-sm fw-normal rounded-0 text-dark bg-warning">Draft</span>',
    3=>'<span class="badge badge-sm fw-normal rounded-0 bg-danger">Pending</span>'
]);
define('MENU_LOCATION_LABEL',[
    1    => '<span class="badge badge-sm fw-normal rounded-0 bg-success">Primary Menu</span>',
    null => '<span class="badge badge-sm fw-normal rounded-0 text-dark bg-warning">Widget Menu</span>',
]);


if(!function_exists('permission')){
    function permission(string $value){
        if(collect(\Illuminate\Support\Facades\Session::get('permission'))->contains($value)){
            return true;
        }
        return false;
    }
}

if (!function_exists('table_checkbox')) {
    function table_checkbox($row_id){
        return '<div class="form-checkbox">
            <input type="checkbox" class="form-check-input select_data" id="checkbox-'.$row_id.'" value="'.$row_id.'" onClick="select_single_item('.$row_id.')">
            <label class="form-check-label" for="checkbox-'.$row_id.'"></label>
        </div>';
    }
}

if (!function_exists('table_image')) {
    function table_image($path,$image,$name){
        return $image ? "<img src='".asset('/').STORAGE_PATH.$path.$image."' alt='".$name."' style='width:40px;'/>"
        : "<img src='".asset('/')."img/default.svg' alt='Default Image' style='width:40px;'/>";
    }
}

if (!function_exists('user_image')) {
    function user_image($gender,$path,$image,$name,$class=null,$style=null){
        if ($image){
            return '<img src="'.asset('/').STORAGE_PATH.$path.$image.'" alt="'.$name.'" style="'.$style.'" class="'.$class.'">';
        }else{
            $img = $gender == '1' ? 'male' : 'female';
            return '<img src="'.asset('/').'img/'.$img.'.svg" alt="'.$name.'" class="'.$class.'" style="'.$style.'">';
        }
    }
}

if (!function_exists('change_status')) {
    function change_status(int $id,int $status,string $name = null){
        return $status == 1 ? '<span class="badge fw-normal rounded-0 bg-success change_status" data-id="' . $id . '" data-name="' . $name . '" data-status="2" style="cursor:pointer;">Active</span>' :
        '<span class="badge fw-normal rounded-0 bg-danger change_status" data-id="' . $id . '" data-name="' . $name . '" data-status="1" style="cursor:pointer;">Inactive</span>';
    }
}

if(!function_exists('tooltip')){
    function tooltip($title,$dir = 'top'){
        return 'data-bs-toggle="tooltip" data-bs-placement="'.$dir.'" title="'.$title.'"';
    }
}

if(!function_exists('dateFormat')){
    function dateFormat($date){
        return date('d-m-Y',strtotime($date));
    }
}

if(!function_exists('api_image_path')){
    function api_image_path($folder){
        return url('/').'/uploads/'.$folder;
    }
}

if(!function_exists('convertBytesToMB')){
    function convertBytesToMB($bytes,$decimals = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return round($bytes / pow(1024, $factor), $decimals) . ' ' . $units[$factor];
    }
}
