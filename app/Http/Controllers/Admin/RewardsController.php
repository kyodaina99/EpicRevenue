<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Reward;
use File;
use Validator;

class RewardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $rewards = Reward::paginate(10);
        return view('admin.rewards.index')->with('rewards', $rewards);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.rewards.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'description'    => 'required|string|max:500',
            'points'         => 'required|integer|min:1|max:10000',
            'image'          => 'required|mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/rewards/create')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        // Store Image
        $file = $request->file('image');
        $destinationPath = public_path() . '/images/rewards/';
        $fileExt = $file->getClientOriginalExtension();
        $filename = strval(time()).".".$fileExt;
        $file->move($destinationPath, $filename);
        $image = $filename;
        
        //create promotion
        $data['image'] = $image;
        $create = Reward::create($data);
        if($create){
            return redirect()->back()
                    ->with('success', 'Reward add success');
        }else{
            return redirect()->back()
                    ->with('error', 'Reward add failed');
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $reward = Reward::find($id);
        return view('admin.rewards.edit')->with('reward', $reward);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:255',
            'description'    => 'required|string|max:500',
            'points'         => 'required|integer|min:1|max:10000',
            'image'          => 'mimes:jpeg,jpg,png'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/rewards/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $reward = Reward::find($id);
        $pre_file = $reward->image;

        if(is_null($reward)){
            return redirect('/admin/rewards')
                ->with('error', 'Record not found');
        }else{
            if($request->hasFile('image')){
                File::delete(public_path() . '/images/rewards/'. $pre_file);

                // Store Image
                $file = $request->file('image');
                $destinationPath = public_path() . '/images/rewards/';
                $fileExt = $file->getClientOriginalExtension();
                $filename = strval(time()).".".$fileExt;
                $file->move($destinationPath, $filename);
                $image = $filename;

                
                $data['image'] = $image;
                $reward->update($data);
                 return redirect('/admin/rewards')
                    ->with('success', 'Reward updated success');
            }else{
                $data['name'] = $request->get('name');
                $data['description'] = $request->get('description');
                $data['points'] = $request->get('points');
                $reward->update($data);
                 return redirect('/admin/rewards')
                    ->with('success', 'Record updated success');
            }
            
           
        }
        
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $reward = Reward::find($id);
        if(is_null($reward)){
            return redirect()->back()
                    ->with('error', 'Not found');
        }else{
          $del = $reward->delete();  
        }
        
        if($del){
            return redirect()->back()
                    ->with('success', 'Record deleted success');
        }else{
            return redirect()->back()
                    ->with('error', 'Record deleted failed');
        }
        //
    }

    public function view()
    {
        $rewards = Reward::get();
        return view('admin.rewards.view')->with('rewards', $rewards);
    }
}
