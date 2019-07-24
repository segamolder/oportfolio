<?php
use App\Models\BlogPost;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/blog', function () {
    return view('blog');
});
Route::get('/blog/getAll', 'Admin\BlogPostsController@GetAll');

Route::get('/blog/posts', function () {
    return BlogPost::paginate(3);
});

Route::get('/blog/post/{id}', 'Admin\BlogPostsController@GetPostById');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/my/account', 'AccountController@index')->name('account');

    //admin
    Route::group(['middleware' => 'IsAdmin'], function () {
        Route::get('/admin/blog/addNew', 'Admin\AccountController@index')->name('addPost');
        Route::post('/admin/addNewPost', 'Admin\BlogPostsController@SaveNewPost')->name('SaveNewPost');
        Route::get('/admin/blog/postList', function (){
            return view('admin/blogPostList');
        })->name('postList');
        Route::get('/admin/blog/editPostView/{id}', 'Admin\BlogPostsController@EditPostView');
        Route::get('/admin/blog/getpost/{id}', 'Admin\BlogPostsController@GetPost');
        Route::post('/admin/blog/editPost', 'Admin\BlogPostsController@EditPost');
        Route::post('/admin/blog/setActiveToggle', 'Admin\BlogPostsController@SetToggle');
    });
});


