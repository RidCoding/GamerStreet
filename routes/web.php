<?php

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

use App\Mail\NewUserWelcomeMail;
use App\User;
use Illuminate\Http\Request;

Auth::routes();

Route::get('/email', function () {
    return new NewUserWelcomeMail();
});

Route::post('follow/{user}', 'FollowsController@store');

Route::get('/', 'PostsController@index');
Route::get('/p/create', 'PostsController@create')->name("post.create");
Route::post('/p', 'PostsController@store');
Route::get('/p/{post}', 'PostsController@show');
Route::get('/search',function(Request $request) {
    $searchTerm = $request->query('search');
    $user = User::select(['users.id','username','image'])
                ->leftJoin('profiles','profiles.user_id','=','users.id')
                ->where('name','like',"%{$searchTerm}%")
                ->orWhere("username","like","%{$searchTerm}%")
                ->get();
                return response()->json($user);
})->name("search");


Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
Route::delete('/post/destroy/{post}', 'PostsController@destroy')->name('post.destroy');

