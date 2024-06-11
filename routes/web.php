<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\zimoajaxcrud;
use App\Http\Controllers\UserAuthController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LogoutController;




//ajaxcrudtask
Route::get('/', [Controller::class, 'Index']);
Route::get('/ajaxcrud/getCompanies', [zimoajaxcrud::class, 'getCompanies']);
Route::post('/ajaxcrud/store', [zimoajaxcrud::class, 'store'])->name('saveCompany');
Route::delete('/ajaxcrud/delete/{id}', [zimoajaxcrud::class, 'delete']);
Route::get('/ajaxcrud/show/{id}', [zimoajaxcrud::class, 'show'])->name('ajaxcrud.show');
Route::get('/ajaxcrud/edit/{id}', [zimoajaxcrud::class, 'edit'])->name('editCompany');
Route::put('/ajaxcrud/update/{id}', [zimoajaxcrud::class, 'update'])->name('updateCompany');


//userauthenticationTask

Route::get('/authTask/loginPage',[LoginController::class,'loginPage']);

Route::get('/ajaxcrud/index', [zimoajaxcrud::class, 'index'])->middleware('auth');


Route::post('/authTask/registerUser',[RegisterController::class,'registerUser']);
Route::post('/authTask/loginUser',[LoginController::class,'loginUser']);
Route::post('/authTask/logoutUser',[LogoutController::class,'logoutUser']);
Route::get('/authTask/authCheck',[UserAuthController::class,'checkAuth']);
// Auth::routes(['verify' => true]);
Route::post('/authTask/checkEmailExists', [RegisterController::class, 'checkEmailExists']);
Route::post('/authTask/verifyOTP', [RegisterController::class, 'verifyOTP']);
Route::post('/authTask/sendOTP', [RegisterController::class, 'sendOTP']);

Route::post('/authTask/sendResetLink', [UserAuthController::class, 'sendResetLinkEmail']);
Route::post('/authTask/ResetPassword', [UserAuthController::class, 'resetPassword']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
