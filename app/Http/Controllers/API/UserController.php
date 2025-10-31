<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
    use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


public function index() {
    return response()->json(User::all());
}

public function store(Request $request){
    $request->validate([
        'name'=>'required|string|max:255',
        'email'=>'required|email|unique:users',
        'password'=>'required|string|min:6',
        'role'=>'required|in:admin,teacher,student'
    ]);

    $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'role'=>$request->role
    ]);

    return response()->json($user,201);
}

public function update(Request $request,$id){
    $user = User::findOrFail($id);

    $user->update($request->only('name','email','role'));
    if($request->password){
        $user->update(['password'=>Hash::make($request->password)]);
    }

    return response()->json($user);
}

public function destroy($id){
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json(['message'=>'Deleted']);
}

}
