<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
Route::any('admin/login','admin/LoginController/index',['method' => 'get|post']);
Route::get('admin/logout','admin/LoginController/logout');
Route::get('captcha','admin/LoginController/captcha');
Route::get('admin/index','admin/IndexController/index');
Route::get('admin/welcome','admin/IndexController/welcome');
Route::resource('admin/article','admin/ArticleController');
Route::resource('admin/category','admin/CategoryController');
Route::resource('admin/picture','admin/PictureController');
Route::resource('admin/system','admin/SystemController');
Route::resource('admin/link','admin/LinkController');
Route::post('admin/upArtImg','admin/UploaderController/uploaderArt');
Route::post('admin/upPicImg','admin/UploaderController/uploaderPic');

Route::get('/','home/IndexController/index');
Route::get('home/list/cat_id/:cat_id','home/ArticleController/listArticle');
Route::get('home/detail/aid/:id','home/ArticleController/detailArticle');
Route::post('search','home/SearchController/search');
Route::post('comment','home/ArticleController/comment');

Route::miss('/');