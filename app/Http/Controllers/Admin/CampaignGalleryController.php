<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campaign;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CampaignGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "Hello World";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $image = $request->file('file');
        $validator = \Validator::make([$image], ['image' => 'required']);
        if ($validator->fails()) {
            return response()->json(['message' => 'Not an image.'], 400);
        }
        $destinationPath = storage_path() . '/uploads';
        if(!$image->move($destinationPath, $image->getClientOriginalName())) {
            return response()->json(['message' => 'Error saving the file.'], 400);
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::findOrFail((int) $id);
        $destinationPath = storage_path() . '/app/images/campaign/' . $campaign->id . '/gallery';
        if( \File::exists($destinationPath) ) {
            $files = collect( scandir($destinationPath) );
            $files->forget([0,1]); // Remove . and ..
            return view('admin.campaigngallery.show', ['campaign' => $campaign, 'files' => $files]);
        }
        return abort(404);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showImage($id, $filename)
    {
        $path = storage_path() . '/app/images/campaign/' . (int) $id . '/gallery/'. $filename;
        if( \File::exists($path) ) {
            $filetype = \File::type($path);
            $response = response()->make(\File::get($path), 200);
            $response->header('Content-Type', $filetype);
            return $response;
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaign = Campaign::find((int) $id);
        return view('admin.campaigngallery.edit', ['campaign' => $campaign]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail((int) $id);
    
        $rules = ['images' => 'array|max:50'];

        $nbr = count($request->input('images')) - 1;
        foreach(range(0, $nbr) as $index) {
            $rules['images.' . $index] = 'image|max:4000';
        }
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/admin/campaigns/gallery/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $images = $request->file('images');
        foreach ($images as $image) {
            $destinationPath = storage_path() . '/app/images/campaign/' . $campaign->id . '/gallery';
            $filename = strval(time()) . "." . $image->getClientOriginalExtension();
            if(!$image->move($destinationPath, $filename)) {
                return response()->json(['message' => 'Error saving the file.'], 400);
            }
        }

        return redirect('/admin/campaigns/gallery/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  array $images
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $filename)
    {
        $path = storage_path() . '/app/images/campaign/' . $id . '/gallery/'.$filename;
        $delete = unlink($path);
        if ($delete)
        {
            return redirect('/admin/campaigns/gallery/'.$id);
        }
        return redirect('/admin/campaigns/gallery/'.$id.'/edit')
            ->withErrors(['file' => 'Image not deleted. Some thing goes wrong']);
    }
}
