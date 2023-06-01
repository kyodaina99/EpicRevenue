<?php

namespace App\Http\Controllers\Admin;

use App\Models\Postback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostbackController extends Controller
{
    public function index()
    {
        $postbacks = Postback::all();
        $bodyid = 'dark';
        return view('admin.postbacks.index', compact('postbacks', 'bodyid'));
    }

    public function create()
    {
        $postback = new Postback();
        return view('admin.postbacks.create', compact('postback'));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        $requestData['veri_slot'] = md5($requestData['name']);
        Postback::create($requestData);
        return redirect('/admin/postbacks');
    }

    public function show($id)
    {
        $postback = Postback::findOrFail((int) $id);
        return compact('postback');
    }

    public function edit($id)
    {
        $postback = Postback::findOrFail((int) $id);
        return view('admin.postbacks.edit', compact('postback'));
    }

    public function update(Request $request, $id)
    {
        Postback::findOrFail((int) $id)->update($request->all());
        return redirect('/admin/postbacks');
    }

    public function destroy($id)
    {
        Postback::findOrFail((int) $id)->delete();
        return redirect('admin/postbacks');
    }
}
