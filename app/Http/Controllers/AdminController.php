<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Admin/Index');
    }
    public function create(Request $request)
    {
        $request->validate([
            'pseudo' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
        $user = User::create([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'bio' => $request->bio,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.index');
    }

    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'pseudo' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);
        $user = User::find($request->id);
        $user->update($request->all());
        return redirect()->route('admin.index');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
    }
}
