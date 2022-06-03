<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
class DropzoneController extends Controller
{
    function index()
    {
        return view('dropzone');
    }

    function upload(Request $request)
    {
        $image = $request->file('file');
        $announcement_id=$request->input('announcement_id');
        $imageName = time().rand(1,1000).'-image-'.time().rand(1,1000).'.'.$image->extension();
        $image->move(public_path('announcement_images'), $imageName);
        $imageUpload = new Image();
        $imageUpload->announcement_id = $announcement_id;
        $imageUpload->image = $imageName;
        $imageUpload->save();
        return response()->json(['success' => $imageName]);
    }



}
?>
