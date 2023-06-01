<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{

    public function store(Request $request)
    {
        if($request->hasFile('file')){

            $upload = new Upload;
            $extension = strtolower($request->file('file')->getClientOriginalExtension());

            $upload->file_original_name = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

            $hash = Str::random(40);
            $size = $request->file('file')->getSize();
            $fileName = $hash . '.' . $extension;

            $request->file('file')->move(public_path() . "/uploads/" . $request->file_type, $fileName);

            $upload->extension = $extension;
            $upload->file_name = $hash . '.' . $extension;
            $upload->user_id = Auth::user()->id;
            $upload->type = $request->file_type;
            $upload->file_size = $size;
            $upload->save();
        }

        return true;
    }

    public function show(Request $request)
    {
        
        $search = $request->has('search') ? $request->search : '';

        $files = Upload::where('user_id', auth()->id())->where('file_original_name', 'LIKE' ,'%' . $search . '%')->orderby('id', 'desc')->paginate(16);
        
        
        if ($request->ajax() && $request->has('page')) {
            return view('filemanager.pagination', ['files' => $files]);
        }
        
        return view('filemanager.modal', ['files' => $files]);
    }
}
