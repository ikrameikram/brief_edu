<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CoursController;
use App\Http\Controllers\API\UserController;


Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class,'logout']);

    
    Route::get('/courses', [CoursController::class,'index']);           // tous les cours
    Route::get('/courses/{id}', [CoursController::class,'show']);       // détail cours
    Route::post('/courses', [CoursController::class,'store'])->middleware('role:teacher'); // créer cours
    Route::put('/courses/{id}', [CoursController::class,'update'])->middleware('role:teacher,admin'); // modifier
    Route::delete('/courses/{id}', [CoursController::class,'destroy'])->middleware('role:teacher,admin'); // supprimer

   
    Route::post('/courses/{id}/enroll', [CoursController::class,'enroll'])->middleware('role:student');
    Route::get('/my-courses', [CoursController::class,'myCourses'])->middleware('role:student');

   
    Route::get('/users', [UserController::class,'index'])->middleware('role:admin');        
    Route::post('/users', [UserController::class,'store'])->middleware('role:admin');       // créer utilisateur
    Route::put('/users/{id}', [UserController::class,'update'])->middleware('role:admin'); // modifier utilisateur
    Route::delete('/users/{id}', [UserController::class,'destroy'])->middleware('role:admin'); // supprimer utilisateur
});
