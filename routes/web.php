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
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'PagesController@index');
Route::group(['middleware' => 'auth'], function() {
    Route::get('/about', 'PagesController@about');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'users'], function() {
        Route::get('/create', 'BBB\UserController@create');
        Route::post('create', 'BBB\UserController@store');
    });
});




/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('servers')->name('servers/')->group(static function() {
            Route::get('/',                                             'ServersController@index')->name('index');
            Route::get('/create',                                       'ServersController@create')->name('create');
            Route::post('/',                                            'ServersController@store')->name('store');
            Route::get('/{server}/edit',                                'ServersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ServersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{server}',                                    'ServersController@update')->name('update');
            Route::delete('/{server}',                                  'ServersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('server-meetings')->name('server-meetings/')->group(static function() {
            Route::get('/',                                             'ServerMeetingsController@index')->name('index');
            Route::get('/create',                                       'ServerMeetingsController@create')->name('create');
            Route::post('/',                                            'ServerMeetingsController@store')->name('store');
            Route::get('/{serverMeeting}/edit',                         'ServerMeetingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ServerMeetingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{serverMeeting}',                             'ServerMeetingsController@update')->name('update');
            Route::delete('/{serverMeeting}',                           'ServerMeetingsController@destroy')->name('destroy');
        });
    });
});
