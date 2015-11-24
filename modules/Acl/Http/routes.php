<?php
/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
|*/
Route::group(['namespace' => 'Modules\Acl\Http\Controllers','middleware' => ['session']], function(){
	
	Route::post('/login', array('as' => 'postlogin','uses' => 'Auth\AuthController@postLogin'));
});
Route::group(['namespace' => 'Modules\Acl\Http\Controllers'], function(){
	
	Route::get('/login', array('as' => 'login','uses' => 'Auth\AuthController@getLogin'));
	Route::get('/logout', array('as' => 'logout','uses' => 'Auth\AuthController@getLogout'));

	// Password reset link request routes...
	Route::get('password/email',array('as' => 'email','uses' => 'Auth\PasswordController@getEmail'));
	Route::post('password/email',array('as' => 'postemail','uses' => 'Auth\PasswordController@postEmail'));

	// Password reset routes...
	Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
	Route::post('password/reset', 'Auth\PasswordController@postReset');
});
/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
|*/
Route::group(['prefix' => 'admin',	'middleware' => ['admin','session'],'namespace' => 'Modules\Acl\Http\Controllers'], function(){

	Route::get('/',array('as' => 'dashboard', 'uses' => 'AclController@index'));
	
	Route::resource('user', 'UserController');
	Route::resource('module', 'ModuleController');
	Route::resource('role', 'RoleController');
	Route::resource('perimeter', 'PerimeterController');
	Route::resource('authorization', 'AuthorizationController');
});
