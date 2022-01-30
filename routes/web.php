<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Page;
use App\Http\Controllers\WebHook;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[Home::class,'index'])->name('home');
Route::post('/',[Home::class,'logres']);

Route::get('/u/{username}',[Page::class,'index']);
Route::post('/sendcomment',[Page::class,'sendComment']);
Route::post('/sendsubcomment',[Profile::class,'sendSubComment']);

Route::get('/saweria',[WebHook::class,'saweria']);

Route::get('/error/{code}',[WebHook::class,'saweria']);

Route::group(['middleware' => ['auth']], function() {
 	Route::get('/profile',[Profile::class,'index']);
   	Route::get('/logout', [Profile::class,'logout']);
   	Route::get('/editprofile', [Profile::class,'editProfileView']);
   	Route::post('/editgeneralprofile', [Profile::class,'editGeneralProfile']);
   	Route::post('/editpage', [Profile::class,'editPage']);
   	Route::get('/deletecomment/{id}', [Profile::class,'deleteComment']);
});