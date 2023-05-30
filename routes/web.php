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

Route::get('certificates/{id?}/print', [CertificateController::class, 'print'])->name('certificates.print');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::resource('certificates', CertificateController::class);

    Route::get('ajax/certificates/code/{code?}', [AjaxController::class, 'code'])->name('ajax-certificate.code');

});

Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
})->name('clear.cache');

