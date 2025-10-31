<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cours;
use App\Models\User;


class CoursController extends Controller
{
    public function index() {
        $cours = Cours::with('teacher')->get();
        return response()->json($cours, 200);
    }

    public function show($id) {
        $cours = Cours::with('teacher','etudiants')->findOrFail($id);
        return response()->json($cours, 200);
    }

    public function store(Request $request){
        $request->validate([
            'titre'=>'required|string|max:255',
            'description'=>'required|string'
        ]);

        $cours = Cours::create([
            'titre'=>$request->titre,
            'description'=>$request->description,
            'user_id'=>auth()->id()
        ]);

        return response()->json($cours,201);
    }

    public function update(Request $request, $id){
        $cours = Cours::findOrFail($id);

        if(auth()->id() !== $cours->user_id && !auth()->user()->isAdmin()){
            return response()->json(['message'=>'Unauthorized'],403);
        }

        $request->validate([
            'titre'=>'sometimes|required|string|max:255',
            'description'=>'sometimes|required|string'
        ]);

        $cours->update($request->only('titre','description'));
        return response()->json($cours,200);
    }

    public function destroy($id){
        $cours = Cours::findOrFail($id);

        if(auth()->id() !== $cours->user_id && !auth()->user()->isAdmin()){
            return response()->json(['message'=>'Unauthorized'],403);
        }

        $cours->delete();
        return response()->json(['message'=>'Deleted'],200);
    }

    public function enroll($id){
        $cours = Cours::findOrFail($id);
        $cours->etudiants()->syncWithoutDetaching([auth()->id()]);
        return response()->json(['message'=>'Enrolled'],200);
    }

    public function myCourses(){
        $cours = auth()->user()->coursInscrits()->with('teacher')->get();
        return response()->json($cours,200);
    }
}
