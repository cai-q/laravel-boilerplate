<?php


Route::get('wechat_oauth_callback', 'Wechat\OAuthController@callback');
Route::get('wechat', 'Wechat\MessageController@serve');