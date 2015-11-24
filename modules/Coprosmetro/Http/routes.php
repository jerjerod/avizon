<?php

Route::group(['prefix' => 'coprosmetro','middleware' => ['auth'], 'namespace' => 'Modules\Coprosmetro\Http\Controllers'], function()
{
	Route::get('/',array('as' => 'coprosmetro.project', 'uses' => 'PostController@index'));
	Route::post('/',array('as' => 'coprosmetro.ajax.index', 'uses' => 'PostController@indexAjax'));
	Route::post('/popup/{id}',array('as' => 'coprosmetro.ajax.single', 'uses' => 'PostController@popupAjax'));
	Route::post('/search/popup/{id}',array('as' => 'coprosmetro.ajaxsearch.single', 'uses' => 'PostController@popupAjax'));
	Route::get('/search',array('as' => 'coprosmetro.search', 'uses' => 'PostController@search'));
	Route::post('/search',array('as' => 'coprosmetro.ajax.search', 'uses' => 'PostController@searchAjax'));

	
	Route::group(['middleware' => ['perim']], function()
	{
		Route::get('{id}',array('as' => 'coprosmetro.show','uses' => 'PostController@show'));
		Route::post('{id}',array('as' => 'coprosmetro.ajax.single', 'uses' => 'PostController@singleAjax'));
	}); 
});

