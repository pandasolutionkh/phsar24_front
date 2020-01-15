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

Route::get('login',[
	'as'=>'login',
	'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login',[
	'as'=>'login',
	'uses' => 'Auth\LoginController@login'
]);
Route::post('logout',[
	'as'=>'logout',
	'uses' => 'Auth\LoginController@logout'
]);

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('register/verify/{token}', 'Auth\RegisterController@verifyUser')->name('verifyUser');


//password
Route::post('password/email',[
	'as'=>'password.email',
	'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);

Route::get('password/reset',[
	'as'=>'password.request',
	'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset',[
	'uses' => 'Auth\ForgotPasswordController@reset'
]);
Route::get('password/reset/{token}',[
	'as'=>'password.reset',
	'uses' => 'Auth\ResetPasswordController@showResetForm'
]);


Route::get('/', 'HomeController@index')->name('home');
Route::get('/contact-us', 'ContactController@index')->name('contact');
Route::post('/contact-us', 'ContactController@store')->name('contact.store');
Route::get('/about-us', 'AboutController@index')->name('about');
Route::get('/terms-conditions', 'TermConditionController@index')->name('term_condition');


Route::get('/profile',[
	'as'=>'profile.index',
	'uses' => 'ProfileController@index'
]);

Route::post('/profile',[
	'as'=>'profile.update',
	'uses' => 'ProfileController@update'
]);

Route::get('/change_password',[
	'as'=>'profile.change_password',
	'uses' => 'ProfileController@changePassword'
]);

Route::post('/change_password',[
	'as'=>'profile.resetPassword',
	'uses' => 'ProfileController@resetPassword'
]);


Route::get('/histories',[
	'as'=>'histories.index',
	'uses' => 'HistoryController@index'
]);

Route::get('/medias/{path}/{filename}/download/',[
	'as'=>'medias.download',
	'uses' => 'MediaController@downloadFile'
]);

Route::post('/medias/upload',[
	'as'=>'medias.upload',
	'uses' => 'MediaController@upload'
]);

Route::post('/medias/upload_video',[
	'as'=>'medias.upload_video',
	'uses' => 'MediaController@uploadVideo'
]);

Route::post('/medias/upload_photos',[
	'as'=>'medias.upload_photos',
	'uses' => 'MediaController@uploadPhotos'
]);

Route::resource('/products','ProductController');
Route::get('/product/{id}',[
	'as'=>'products.detail',
	'uses' => 'HomeController@product'
]);

Route::get('/favorites',[
	'as'=>'favorites.index',
	'uses' => 'FavoriteController@index'
]);
Route::delete('/favorites/delete/{id}',[
	'as'=>'favorites.delete',
	'uses' => 'FavoriteController@deleteFavorite'
]);

Route::post('/favorites/dofav/{id}',[
	'as'=>'favorites.dofav',
	'uses' => 'FavoriteController@doFavorite'
]);

Route::get('/profile/contact',[
	'as'=>'profile.contact',
	'uses' => 'ProfileController@contact'
]);

Route::post('/profile/contact',[
	'as'=>'profile.create_contact',
	'uses' => 'ProfileController@createContact'
]);

Route::get('/shop/{id}',[
	'as'=>'shop.index',
	'uses' => 'UserController@index'
]);

Route::get('/shop/{id}/contact',[
	'as'=>'shop.contact',
	'uses' => 'UserController@contact'
]);

Route::get('/category/{slug}',[
	'as'=>'categories.index',
	'uses' => 'CategoryController@index'
]);

Route::get('/category/{category_slug}/{sub_category_slug}',[
	'as'=>'categories.sub',
	'uses' => 'CategoryController@sub'
]);

