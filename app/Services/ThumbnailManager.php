<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

trait ThumbnailManager
{
    public function storeThumbnail($request){
        if ($request->hasFile('thumbnail')){
            $fileNameWithExt = $request->file('thumbnail')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $storeFileName = hash('sha256', auth()->user()->id.$fileName.time()).'.'.$extension;
            $request->file('thumbnail')->storeAs('/public/thumbnails', $storeFileName);
            return $storeFileName;
        }
        return null;
    }

    public function deleteThumbnail($obj){
        if (!empty($obj->thumbnail_path))
            Storage::delete('/public/thumbnails/'.$obj->thumbnail_path);
    }
}
