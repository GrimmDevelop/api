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

$this->get('/', function () {
    return redirect('/docs');
});

$this->get('/docs', function() {
    return view('documentation');
});

$this->get('docs/{page}', function($page) {
    $page = 'docs.' . $page;
    if (view()->exists($page)) {
        return view($page);
    }

    return abort(404);
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

$this->group(['prefix' => 'v1', 'middleware' => ['api']], function () {

    $this->post('find/book', ['as' => 'v1.find.book', 'uses' => 'ApiV1\\Open\\FindController@book']);

    $this->group(['middleware' => ['auth:api']], function() {
        $this->get('find/person', ['as' => 'v1.find.person', 'uses' => 'ApiV1\\Open\\PersonsController@findByName']);
        $this->get('persons', ['as' => 'v1.persons.index', 'uses' => 'ApiV1\\Open\\PersonsController@index']);
        $this->get('persons/{id}', ['as' => 'v1.persons.show', 'uses' => 'ApiV1\\Open\\PersonsController@show']);

        $this->get('books', ['as' => 'v1.books.index', 'uses' => 'ApiV1\\Open\\BooksController@index']);
        $this->get('books/{id}', ['as' => 'v1.books.show', 'uses' => 'ApiV1\\Open\\BooksController@show']);
    });
});
