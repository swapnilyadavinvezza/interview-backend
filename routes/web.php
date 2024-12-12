<?php

use App\Http\Controllers\Admin\ExamEnrollmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookletController;
use App\Http\Controllers\Admin\BookletQuestionController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword');
    Route::put('/changePasswordUpdate', [ProfileController::class, 'changePasswordUpdate'])->name('user.changePasswordUpdate');
    Route::get('/resetPassword/{id}', [UserController::class, 'resetPassword']);
    Route::put('/resetPassword/{id}', [UserController::class, 'sendResetUpdate'])->name('reset.password.update');
    Route::resource('users', UserController::class);
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    Route::get('/user/status/{id}', [UserController::class, 'status'])->name('user.status');
    Route::get('/user/export', [UserController::class, 'export'])->name('user.export');
    Route::resource('booklets', BookletController::class);
    Route::get('/booklet/edit/{id}', [BookletController::class, 'edit'])->name('booklet.edit');
    Route::post('/booklet/update', [BookletController::class, 'update'])->name('booklet.update');
    Route::get('/booklet/delete/{id}', [BookletController::class, 'destroy'])->name('booklet.delete');
    Route::resource('bookletQuestion', BookletQuestionController::class);
    Route::get('/booklet/question/delete/{id}', [BookletQuestionController::class, 'destroy'])->name('booklet.question.delete');
    
    // Define resource routes for exam enrollments and custom routes for edit, update, and delete actions.
    Route::resource('examEnrollments', ExamEnrollmentController::class);
    Route::get('/examEnrollment/edit/{id}', [ExamEnrollmentController::class, 'edit'])->name('examEnrollments.edit');
    Route::post('/examEnrollment/update', [ExamEnrollmentController::class, 'update'])->name('examEnrollments.update');
    Route::get('/examEnrollment/delete/{id}', [ExamEnrollmentController::class, 'destroy'])->name('examEnrollments.delete');
    // Route for fetching soft-deleted exam enrollments
    // Route to restore a soft-deleted exam enrollment
    Route::get('/examEnrollment/restore/{id}', [ExamEnrollmentController::class, 'restoreExamEnrollment'])->name('examEnrollment.restore');


});

require __DIR__.'/auth.php';
