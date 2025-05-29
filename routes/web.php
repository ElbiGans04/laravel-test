<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth:web'])->group(function () {
    Route::get('/', [UserController::class, 'indexView'])->name('index')->middleware(['permission:users.read']);

    Route::group(['prefix' => '/users', 'as' => 'users.'], function () {
        Route::get('/create', [UserController::class, 'createView'])->name('create')->middleware(['permission:users.create']);
        Route::post('/create', [UserController::class, 'create'])->name('create.post')->middleware(['permission:users.create']);
        Route::get('/update', [UserController::class, 'updateView'])->name('update')->middleware(['permission:users.update']);
        Route::post('/update', [UserController::class, 'update'])->name('update.post')->middleware(['permission:users.update']);
        Route::get('/delete', [UserController::class, 'delete'])->name('delete')->middleware(['permission:users.delete']);
    });

    Route::group(['prefix' => '/roles', 'as' => 'roles.'], function () {
        Route::get('', [RoleController::class, 'indexView'])->name('index')->middleware(['permission:roles.read']);
        Route::get('/create', [RoleController::class, 'createView'])->name('create')->middleware(['permission:roles.create']);
        Route::post('/create', [RoleController::class, 'create'])->name('create.post')->middleware(['permission:roles.create']);
        Route::get('/update', [RoleController::class, 'updateView'])->name('update')->middleware(['permission:roles.update']);
        Route::post('/update', [RoleController::class, 'update'])->name('update.post')->middleware(['permission:roles.update']);
        Route::get('/delete', [RoleController::class, 'delete'])->name('delete')->middleware(['permission:roles.delete']);
    });

    Route::group(['prefix' => '/permissions', 'as' => 'permissions.'], function () {
        Route::get('', [PermissionController::class, "indexView"])->name('index')->middleware(['permission:permissions.read']);
        Route::get('/create', [PermissionController::class, "createView"])->name('create')->middleware(['permission:permissions.create']);
        Route::post('/create', [PermissionController::class, "create"])->name('create.post')->middleware(['permission:permissions.create']);
        Route::get('/update', [PermissionController::class, "updateView"])->name('update')->middleware(['permission:permissions.update']);
        Route::post('/update', [PermissionController::class, "update"])->name('update.post')->middleware(['permission:permissions.update']);
        Route::get('/delete', [PermissionController::class, "delete"])->name('delete')->middleware(['permission:permissions.delete']);
    });
});

Route::group(['prefix' => '/auth'], function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
