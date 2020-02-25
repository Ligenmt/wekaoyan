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

//用户模块
Route::get('/register', '\App\Http\Controllers\RegisterController@index');
Route::post('/register', '\App\Http\Controllers\RegisterController@register');
Route::post('/register/sms', '\App\Http\Controllers\RegisterController@sendSms');
Route::get('/login', '\App\Http\Controllers\LoginController@index');
Route::post('/login', '\App\Http\Controllers\LoginController@login');
Route::get('/logout', '\App\Http\Controllers\LoginController@logout');
Route::get('/forgot', '\App\Http\Controllers\LoginController@forgot');
Route::post('/forgot/sms', '\App\Http\Controllers\LoginController@forgotSms');
Route::post('/forgot/reset', '\App\Http\Controllers\LoginController@forgotReset');
//Route::get('/user/me/setting', '\App\Http\Controllers\UserController@setting');
//Route::post('/user/me/setting', '\App\Http\Controllers\UserController@settingSave');
//主页
Route::get('/search', '\App\Http\Controllers\IndexController@search');
Route::get('/', '\App\Http\Controllers\IndexController@index');
Route::get('/index', '\App\Http\Controllers\IndexController@index');
Route::get('/forum/focus', '\App\Http\Controllers\ForumController@allfocusforum');
Route::get('/forum/{name}', '\App\Http\Controllers\ForumController@forum');
Route::get('/forums', '\App\Http\Controllers\ForumController@forums');
Route::get('/forum/focus/{forum}', '\App\Http\Controllers\ForumController@focusforum');

Route::post('/changeforum', '\App\Http\Controllers\ForumController@changeForumPost');
Route::get('/changeforum/{forum_id}', '\App\Http\Controllers\ForumController@changeForumGet');

//研友交流
Route::get('/shuoshuo', '\App\Http\Controllers\ShuoshuoController@index');
Route::get('/shuoshuo/post', '\App\Http\Controllers\ShuoshuoController@post');
Route::post('/shuoshuo/dopost', '\App\Http\Controllers\ShuoshuoController@doPost');
Route::post('/shuoshuo/postcomment/{shuoshuo}', '\App\Http\Controllers\ShuoshuoController@postComment');
Route::post('/shuoshuo/postupvote/{shuoshuo}', '\App\Http\Controllers\ShuoshuoController@postUpvote');
//经验帖
Route::get('/experience', '\App\Http\Controllers\ExperienceController@index');
Route::get('/experience/post', '\App\Http\Controllers\ExperienceController@post');
Route::post('/experience/dopost', '\App\Http\Controllers\ExperienceController@doPost');
Route::get('/experience/{experience}', '\App\Http\Controllers\ExperienceController@show');
Route::post('/experience/postcomment/{experience}', '\App\Http\Controllers\ExperienceController@postComment');
Route::post('/experience/postupvote/{experience}', '\App\Http\Controllers\ExperienceController@postUpvote');
//问答
Route::get('/question', '\App\Http\Controllers\QuestionController@index');
Route::get('/question/post', '\App\Http\Controllers\QuestionController@post');
Route::post('/question/dopost', '\App\Http\Controllers\QuestionController@doPost');
Route::get('/question/{question}', '\App\Http\Controllers\QuestionController@show');
Route::post('/question/focus/{question}', '\App\Http\Controllers\QuestionController@focus');
Route::post('/answer/dopost', '\App\Http\Controllers\AnswerController@doPost');
Route::post('/answer/upvote/{answer}', '\App\Http\Controllers\AnswerController@upvote');

//资料下载
Route::get('/examdata', '\App\Http\Controllers\ExamdataController@zhenti');
Route::get('/examdata/zhenti', '\App\Http\Controllers\ExamdataController@zhenti');
Route::get('/examdata/data', '\App\Http\Controllers\ExamdataController@data');
Route::post('/examdata/postcomment', '\App\Http\Controllers\ExamdataController@postComment');
Route::post('/upload', '\App\Http\Controllers\FileController@upload');
Route::get('/download/{id}', '\App\Http\Controllers\FileController@download');
Route::post('/upload/image', '\App\Http\Controllers\FileController@uploadImage');

//真题
Route::get('/zhenti', '\App\Http\Controllers\ZhentiController@index');

//消息提醒
Route::get('/loadnotif', '\App\Http\Controllers\NotificationController@unreadNotif');
Route::get('/notifications', '\App\Http\Controllers\NotificationController@notifications');
Route::get('/clear_notifications', '\App\Http\Controllers\NotificationController@clear');

//个人中心
Route::get('/user/{user}', '\App\Http\Controllers\UserController@basic');
Route::get('/user/{user}/basic', '\App\Http\Controllers\UserController@basic');
Route::get('/user/{user}/shuoshuo', '\App\Http\Controllers\UserController@shuoshuo');
Route::get('/user/{user}/experience', '\App\Http\Controllers\UserController@experience');
Route::get('/user/{user}/file', '\App\Http\Controllers\UserController@file');
Route::get('/user/{user}/question', '\App\Http\Controllers\UserController@question');
Route::get('/user/{user}/answer', '\App\Http\Controllers\UserController@answer');
Route::get('/user/{user}/focusforum', '\App\Http\Controllers\UserController@focusforum');
