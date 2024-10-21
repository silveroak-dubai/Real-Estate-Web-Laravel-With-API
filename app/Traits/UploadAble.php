<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Trait UploadAble
 * @package App\Traits
 */
trait UploadAble
{

    /**
     * * Upload File Method * *
     * @param UploadedFile $file
     * @param null $folder
     * @param null $filename
     * @param null $disk
     * @return false|string
     */
    public function upload_file(UploadedFile $file, $folder = null,  $file_name = null, $disk = 'public')
    {
        if (!Storage::disk($disk)->exists($folder)) {
            Storage::disk($disk)->makeDirectory($folder, 0777, true);
        }

        $filenameWithExt = $file->getClientOriginalName();
        $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension       = strtolower($file->getClientOriginalExtension());

        $fileNameToStore = !is_null($file_name) ?
            str()->slug($file_name,'-') . '.' . $extension :
            str()->slug($filename,'-') . '-' . time() . '.' . $extension;

        $file->storeAs($folder,$fileNameToStore,$disk); //store file in targetted folder
        return $fileNameToStore;
    }

    /**
     * ! Delete File Method !
     * @param string $filename
     * @param string $folder
     * @param string $disk
     * @return true|false
     */
    public function delete_file($filename,$folder,$disk = 'public')
    {
        if(Storage::exists($disk.'/'.$folder.$filename))
        {
            Storage::disk($disk)->delete($folder.$filename);
            return TRUE;
        }
        return false;
    }
}
