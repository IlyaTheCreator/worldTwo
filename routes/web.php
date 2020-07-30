<?php

use Illuminate\Support\Facades\Route;

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

Route::get('get-user', 'AppController@getUser');

Route::post('admin-login', 'AppController@login');

Route::get('login-check', 'AppController@loginCheck');
Route::get('get-applications', 'AppController@getApplications');
Route::get('get-templates', 'AppController@getTemplates');

Route::post('admin/create-template', 'AppController@createTemplate');
Route::post('delete-template', 'AppController@deleteTemplate');

Route::post('apply', 'AppController@apply');
Route::post('/decline', 'AppController@decline');
Route::post('/accept', 'AppController@accept');
Route::post('print-application', 'AppController@printApplication');
Route::post('sort', 'AppController@sort');

Route::view('/', 'home');
Route::view('admin-login', 'admin-login');
Route::view('admin/home', 'admin-home');
Route::view('admin/templates', 'admin-templates');
Route::view('admin/new-template', 'admin-new-template');
