<?php

namespace App\Services;

class ImageSaver
{
    private $fileName;

    public function __construct($request = null)
    {
        if (!empty($request))
            $this->save($request);
    }

    public function save($request){
        $fileNameWithExt = $request->file('thumbnail')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('thumbnail')->getClientOriginalExtension();
        $this->fileName = hash('sha256', auth()->user()->id.$fileName.time()).'.'.$extension;
        $request->file('thumbnail')->storeAs('/public/thumbnails', $this->fileName);
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
