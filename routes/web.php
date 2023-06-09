<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\ContactForm;
use App\Http\Livewire\Counter;
use App\Http\Livewire\Polling;
use App\Http\Livewire\PostEditPage;
use App\Http\Livewire\UsersDatatable;
use App\Livewire;
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

Route::post('/livewire', function () {
    // Get a component from snapshot
    $component = (new Livewire)->fromSnapshot(request('snapshot'));
    // Call a method of component
    if ($method = request('method')) {
        (new Livewire)->call($component, $method);
    }

    // Update property
    if ([$property, $value] = request('updateProperty')) {
        (new Livewire)->updateProperty($component, $property, $value);
    }

    [$html, $snapshot] = (new Livewire)->toSnapshot($component);

    return [
        'html' => $html,
        'snapshot' => $snapshot,
    ];
});

Route::get('/counter', fn() => view('counter'))->name('counter');
Route::get('/tasks', fn() => view('tasks'))->name('tasks');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
