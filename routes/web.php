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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    Session::put('redirectTo', '/');
    return view('welcome');
});

Route::get('lisa', function () {
    if (Auth::check()) {
        return view ('lisa');
    } else {
        return redirect('/');
    }
});

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/meist', function () {
    Session::put('redirectTo', '/meist');
    return view('meist');
});

Route::get('/profiil', function () {
    Session::put('redirectTo', '/profiil');
    return view('profile');
});


/*
Route::get('postitus', function () {
    return view ('postitus');
});*/

Route::get("postitus", 'postitusController@index');

//Route::get('/lisa', ['as' => 'lisa', 'uses' => 'lisaController@create']);

//Route::post('/lisa', ['as' => '/lisatud', 'uses' => 'lisaController@store']);

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'langController@changeLocale']);

Route::get("lisa", 'lisaController@index');

Route::post("store", "lisaController@store");

Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

/*
 *  route redirect on selleks, et väljakutsuda facebooki autentimise teenust
 *  route callback annab meile tagasi facebooki vastuse ja sellega saame sellega midagi teha
 */
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Auth::routes();
