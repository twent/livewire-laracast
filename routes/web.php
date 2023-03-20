<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\ContactForm;
use App\Http\Livewire\Polling;
use App\Http\Livewire\PostEditPage;
use App\Http\Livewire\UsersDatatable;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::get('/contact', ContactForm::class)->name('contact');

Route::get('/users', UsersDatatable::class)->name('users');

Route::get('/blog', [PostController::class, 'index'])->name('blog');
Route::get('/blog/{post}', [PostController::class, 'show'])->name('post');
Route::get('/blog/{post}/edit', PostEditPage::class)->name('post.edit');

Route::get('/polling', Polling::class)->name('polling');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
