<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserPaymentMethod;
use Illuminate\Http\Request;

class UserPaymentMethodController extends Controller
{
    public function index()
    {
        $userPaymentMethods = UserPaymentMethod::all();
        return view('admin.payments.methods.index', compact('userPaymentMethods'));
    }

    public function create()
    {
        return view('admin.payments.methods.create');
    }

    public function store(Request $request)
    {
        $userPaymentMethod = UserPaymentMethod::create($request->all());
        return redirect()->route('methods.index');
    }

    public function show(UserPaymentMethod $userPaymentMethod)
    {
        return view('admin.payments.methods.show', compact('userPaymentMethod'));
    }

    public function edit(UserPaymentMethod $userPaymentMethod)
    {
        return view('admin.payments.methods.edit', compact('userPaymentMethod'));
    }

    public function update(Request $request, UserPaymentMethod $userPaymentMethod)
    {
        $userPaymentMethod->update($request->all());
        return redirect()->route('methods.index');
    }

    public function destroy(UserPaymentMethod $userPaymentMethod)
    {
        $userPaymentMethod->delete();
        return redirect()->route('methods.index');
    }
}
