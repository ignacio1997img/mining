<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CompanyController;
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

Route::get('/', function () {
    // return view('welcome');
    return redirect('admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::resource('certificates', CertificateController::class);
    Route::get('certificates/{id?}/print', [CertificateController::class, 'print'])->name('certificates.print');

    Route::get('ajax/certificates/code/{code?}', [AjaxController::class, 'code'])->name('ajax-certificate.code');

});
