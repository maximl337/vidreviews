<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('reviews/{user}', 'HomeController@indexPublic')->name('public-reviews');

Route::post('review/approve', 'HomeController@approveReview')->name('approve');

Route::post('review/disapprove', 'HomeController@disapproveReview')->name('disapprove');

Route::get('invite', 'InviteController@invite')->name('invite');

Route::post('invite', 'InviteController@sendInvite')->name('send-invite');

Route::get('invite/{email}/{token}', 'InviteController@acceptInvite')->name('accept-invite');

Route::post('invite/review/submit', 'InviteController@submitReview')->name('submit-review');




