<?php

Route::get('/two-factor-auth/request-token',
    'TokenSenderController@issueToken')
->name('2factor.requestToken');
