<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('documentation');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

// Api

Route::group(['prefix' => 'v1', 'middleware' => ['api']], function () {

    Route::post('find/book', ['as' => 'v1.find.book', 'uses' => 'ApiV1\\Open\\FindController@book']);
    Route::post('find/person', ['as' => 'v1.find.person', 'uses' => 'ApiV1\\Open\\FindController@person']);

    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('persons', ['as' => 'v1.persons.index', 'uses' => 'ApiV1\\Open\\PersonsController@index']);
        Route::get('persons/{id}', ['as' => 'v1.persons.show', 'uses' => 'ApiV1\\Open\\PersonsController@show']);

        Route::get('books', ['as' => 'v1.books.index', 'uses' => 'ApiV1\\Open\\BooksController@index']);
        Route::get('books/{id}', ['as' => 'v1.books.show', 'uses' => 'ApiV1\\Open\\BooksController@show']);

        // protected: Route::post('books/{id}/persons', 'ApiV1\\Open\\BooksController@addPersonToBook');
    });
});
