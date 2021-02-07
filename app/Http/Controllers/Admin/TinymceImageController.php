<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TinymceImageController extends Controller
{
    public function store(Request $request)
    {
        $imgpath = $request->file('file')->store('uploads', 'public');
        return response()->json(['location' => asset('storage/'.$imgpath)]);
    }
}
