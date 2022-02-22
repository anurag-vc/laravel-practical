
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Employee\EmployeeController;

Route::group(['prefix' => '/'], function () {
    Route::resource('employee', EmployeeController::class)->except(['show']);
});
