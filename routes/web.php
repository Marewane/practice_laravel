<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::get('/welcomePage', function () {
    return view('welcome');
});



Route::get('/sendData',function(){
    return view('dataSent',['datatoSent'=>"Hello Marewane"]);
})->name('sendData');

Route::get('getPosts',[PostsController::class,'getPosts'])->name('getPosts');

Route::get('createPost',[PostsController::class,'redirectToCreatePost'])->name('redirectToCreatePost');
Route::post('createPost',[PostsController::class,'createPost'])->name('createPost');

Route::get('editPost/{id}',[PostsController::class,'editPost'])->name('editPost');

Route::put('updatePost/{id}',[PostsController::class,'updatePost'])->name('updatePost');

Route::delete('deletePost/{id}',[PostsController::class,'deletePost'])->name('deletePost');