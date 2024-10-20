<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    use UploadAble;

    public function index(){
        $breadcrumb = ['Media'=>''];
        $this->set_page_data('Media','Media');
        return view('media.index',compact('breadcrumb'));
    }

    public function mediaRender(Request $request){
        if ($request->ajax()) {
            $medias = Media::latest()->get();
            $maxSize = DB::table('medias')->sum('file_size');
            $maxSize = convertBytesToMB($maxSize);
            $view = view('media.render',compact('medias'))->render();
            return response()->json(['view'=>$view,'size'=>$maxSize]);
        }
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'files.*'=>['required','mimes:png,jpg,jpeg,gif,mp4,pdf','max:5120']
            ]);

            if($validator->fails()){
                return response()->json(['status'=>false,'errors'=>$validator->errors()]);
            }

            if($request->hasFile('files')){
                $uploadedFiles = $request->file('files');
                $uploadedFileData = [];

                foreach ($uploadedFiles as $file) {
                    $fileSize = $file->getSize();
                    $filePath = $this->upload_file($file,'media/');
                    $uploadedFileData[] = [
                        'user_id'    => auth()->user()->id,
                        'name'       => $file->getClientOriginalName(),
                        'path'       => $filePath,
                        'extension'  => $file->getClientOriginalExtension(),
                        'size'       => convertBytesToMB($fileSize),
                        'file_size'  => $fileSize,
                        'created_at' => now()
                    ];
                }

                Media::insert($uploadedFileData);

                return response()->json(['status'=>'success','message'=>'File uploaded.']);
            }else{
                return response()->json(['status'=>'error','message'=>'File cannot uploaded!']);
            }
        }
    }

    public function delete(Request $request){
        if($request->ajax()){
            $media = Media::find($request->id);
            if($media){
                $this->delete_file($media->path,'media/');
                $media->delete();
                return response()->json(['status'=>'success','message'=>'File deleted.']);
            }else{
                return response()->json(['status'=>'error','message'=>'File cannot deleted!']);
            }
        }
    }
}
