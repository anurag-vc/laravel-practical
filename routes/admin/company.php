
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Company\CompanyController;

Route::group(['prefix' => '/'], function () {
    Route::resource('company', CompanyController::class)->except(['show']);
});
