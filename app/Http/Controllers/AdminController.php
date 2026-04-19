<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class AdminController extends Controller
{
    //
    public function index(Request $request)
{
    $users = User::query()
        ->when($request->search, function($query, $search) {
            $query->where('name', '~*', $search)
                  ->orWhere('email', '~*' , $search);
        })
        ->latest()
        ->paginate(10);

    return Inertia::render('Admin', [
        'Users' => $users,
    ]);
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
            'password' => $request->password, //Hash::make($request->password),
        ]);
        return redirect()->route('admin.index');
    }

    
    //public function update(Request $request)
    //{
       // $request->validate([
         //   'id' => 'required|integer',
         //   'pseudo' => 'required|string|max:255',
         //   'email' => 'required|email|max:255',
          //  'bio' => 'required|string|max:255',
           // 'role' => 'required|string|max:255',
        //]);
       // $user = User::find($request->id);
       // $user->update($request->all());
       // return redirect()->route('admin.index');
    //}


    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
    }
}
