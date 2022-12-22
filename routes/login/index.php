<?php
	
    /*
    |-------------------------------------------------------
    | LOGIN
    |-------------------------------------------------------
    */
    /**login */
    Route::get('/login.htm', [App\Http\Controllers\Backend\Auth\LoginController::class, 'loginForm'])->name(ADMIN_ROUTE . '.loginform');
    Route::post('/login.htm', [App\Http\Controllers\Backend\Auth\LoginController::class, 'login'])->name(ADMIN_ROUTE . '.login');
    Route::get('/logout.htm', [App\Http\Controllers\Backend\Auth\LoginController::class, 'logout'])->name(ADMIN_ROUTE . '.logout');
