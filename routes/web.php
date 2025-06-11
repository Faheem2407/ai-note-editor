<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AIEnhancementController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');


Route::get('/login', function () {
    return redirect('/');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
		$notes = auth()->user()->notes()->latest()->get();
        return view('dashboard', compact('notes'));
    })->name('dashboard');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


Route::middleware('auth')->group(function () {
    Route::resource('notes', NoteController::class);
});

Route::post('/ai/summarize', [AIEnhancementController::class, 'summarize'])->name('ai.summarize');



