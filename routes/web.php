<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\TcodeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Started\StartedCompanyController;
use App\Http\Controllers\Started\StartedWelcomeController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\CompanyController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Home\UsersController;
use App\Http\Controllers\Home\RolesController;
use App\Http\Controllers\Reports\ReportsController;
use App\Http\Controllers\Masters\MastersController;


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

Route::get('/lang', [LangController::class, 'selectLang']);
Route::post('/tcode', [TcodeController::class,'tcode'])->middleware('auth','verified');

Route::get('/auth/login', [LoginController::class,'login'])->name('login')->middleware('guest');
Route::post('/auth/login', [LoginController::class,'store']);
Route::get('/auth/logout', [LoginController::class,'logout'])->name('logout');

Route::get('/auth/register', [RegisterController::class,'register'])->name('register')->middleware('guest');
Route::post('/auth/register', [RegisterController::class,'store']);

Route::get('/email/verify', [EmailVerificationController::class,'notice'])->name('verification.notice')->middleware('auth');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class,'verify'])->name('verification.verify')->middleware(['auth', 'signed']);
Route::post('/email/verification-notification', [EmailVerificationController::class,'send'])->name('verification.send')->middleware(['auth', 'throttle:6,1']);

Route::get('/auth/forgot-password', [ForgotPasswordController::class,'request'])->name('password.request')->middleware('guest');
Route::post('/auth/forgot-password', [ForgotPasswordController::class,'email'])->name('password.email')->middleware('guest');
Route::get('/auth/reset-password/{token}', [ForgotPasswordController::class,'reset'])->name('password.reset')->middleware('guest');
Route::post('/auth/reset-password', [ForgotPasswordController::class,'update'])->name('password.update')->middleware('guest');

Route::get('/started/company', [StartedCompanyController::class,'company'])->name('started1')->middleware('auth','verified','role');
Route::post('/started/company', [StartedCompanyController::class,'store'])->middleware('auth','verified','role');
Route::get('/welcome', [StartedWelcomeController::class,'welcome'])->name('welcome')->middleware('auth','verified','role');
Route::post('/welcome', [StartedWelcomeController::class,'store'])->middleware('auth','verified','role');

Route::get('/', [HomeController::class,'home'])->name('index')->middleware('auth','verified','role');
Route::get('/home', [HomeController::class,'home'])->name('home')->middleware('auth','verified','role');
Route::get('/profile', [ProfileController::class,'profile'])->name('profile')->middleware('auth','verified','role');
Route::post('/profile/change_password', [ProfileController::class,'change_password'])->middleware('auth','verified');
Route::post('/profile/change_atribute', [ProfileController::class,'change_atribute'])->middleware('auth','verified');
Route::get('/company', [CompanyController::class,'company'])->name('company')->middleware('auth','verified','role');
Route::post('/company/change_logo', [CompanyController::class,'change_logo'])->middleware('auth','verified');
Route::get('/company/edit', [CompanyController::class,'edit'])->name('company.edit')->middleware('auth','verified');
Route::post('/company/edit', [CompanyController::class,'update'])->middleware('auth','verified');

Route::resource('users',UsersController::class)->only(['index','create','edit'])->names(['index' => 'users'])->middleware(['auth','verified','role']);
Route::resource('users',UsersController::class)->only(['store','update','show'])->middleware(['auth','verified']);
Route::get('/users/{id}/reset', [UsersController::class,'reset'])->name('users.reset')->middleware('auth','verified','role');
Route::post('/users/flexigrid', [UsersController::class,'flexigrid'])->middleware('auth','verified');

Route::get('/roles/{id}/delete', [UsersController::class,'delete'])->name('roles.delete')->middleware('auth','verified','role');
Route::resource('roles',RolesController::class)->only(['index','create','edit'])->names(['index' => 'roles'])->middleware(['auth','verified','role']);
Route::resource('roles',RolesController::class)->only(['store','update','show','destroy'])->middleware(['auth','verified']);
Route::post('/roles/flexigrid', [RolesController::class,'flexigrid'])->middleware('auth','verified');
Route::post('/roles/duallist', [RolesController::class,'duallist'])->middleware('auth','verified');

Route::get('/reports', [ReportsController::class,'reports'])->name('reports')->middleware('auth','verified','role');
Route::get('/masters', [MastersController::class,'masters'])->name('masters')->middleware('auth','verified','role');