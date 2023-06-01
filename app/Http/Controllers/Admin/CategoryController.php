<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PromotionCategory;
use Validator;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = PromotionCategory::get();
        return view('admin.promotions.categories.index')->with(compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
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
            'name' => 'required|unique:promotion_categories'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/promotions/categories')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $create = PromotionCategory::create($data);
        if($create){
            return redirect()->back()
                    ->with('success', 'Category Add Success');
        } else {
            return redirect()->back()
                    ->with('error', 'Category add failed');
        }
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
        $category = PromotionCategory::find($id);
        return view('admin.promotions.categories.edit')->with('category', $category);
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
        $cate = PromotionCategory::find($id);

        if(is_null($cate)){
            return redirect()->route('category.index')
                ->with('error', 'Record not found');
        }else{
            $cate->update($request->all());
            return redirect()->route('category.index')
            ->with('success', 'Record updated success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $cate = PromotionCategory::find($id);
        if(is_null($cate)){
            return redirect()->back()
                    ->with('error', 'Not found');
        }else{
          $del = $cate->delete();  
        }
        
        if($del){
            return redirect()->back()
                    ->with('success', 'Record delete success');
        }else{
            return redirect()->back()
                    ->with('error', 'Record delete failed');
        }
    }
}
