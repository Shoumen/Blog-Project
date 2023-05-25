<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FrontEndController;

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

// Route::get('/', function () {
//     return view('website/home');
// })->name('website');

// Front End Routes
Route::get('/', [FrontEndController::class,'home'])->name('website');
Route::get('/about', [FrontEndController::class, 'about'])->name('website.about');
Route::get('/category/{slug}', [FrontEndController::class,'category'])->name('website.category');
Route::get('/tag/{slug}', [FrontEndController::class,'tag'])->name('website.tag');
Route::get('/contact', [FrontEndController::class,'contact'])->name('website.contact');
Route::get('/post/{slug}', [FrontEndController::class, 'post'])->name('website.post');

Route::post('/contact', [FrontEndController::class, 'send_message'])->name('website.message');

Route::get('/dashboard', function () {
    return view('admin/dashboard/index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user', [ProfileController::class, 'index'])->name('user.index');
    Route::get('/user/create', [ProfileController::class, 'create'])->name('user.create');
    Route::post('/user', [ProfileController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [ProfileController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{user}', [ProfileController::class, 'update'])->name('user.update');
    Route::Delete('/user/{user}', [ProfileController::class, 'destroy'])->name('user.destroy');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update/{user}', [ProfileController::class, 'profile_update'])->name('user.profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::PUT('/category/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('/category/show', [CategoryController::class, 'show'])->name('admin.category.show');
    Route::Delete('/category/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    
    Route::get('/tag', [TagController::class,'index'])->name('tag.index');
    Route::get('/tag/create', [TagController::class, 'create'])->name('tag.create');
    Route::post('/tag/store', [TagController::class, 'store'])->name('tag.store');
    Route::get('/tag/{tag}/edit', [TagController::class, 'edit'])->name('tag.edit');
    Route::PUT('/tag/update/{tag}', [TagController::class, 'update'])->name('tag.update');
    Route::get('/tag/show', [TagController::class, 'show'])->name('tag.show');
    Route::Delete('/tag/{tag}', [TagController::class, 'destroy'])->name('tag.destroy');

    Route::get('/post', [PostController::class,'index'])->name('post.index');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::PUT('/post/update/{post}', [PostController::class, 'update'])->name('post.update');
    Route::get('/post/{post}/show', [PostController::class, 'show'])->name('post.show');
    Route::Delete('/post/{post}', [TagController::class, 'destroy'])->name('post.destroy');


    //  Contact message
    Route::get('message',[ContactController::class,'index'])->name('contact.index');
    Route::get('/message/show/{id}',[ContactController::class,'show'])->name('contact.show');
    Route::delete('/message/delete/{id}',[ContactController::class,'destroy'])->name('contact.destroy');


    // setting
    Route::get('setting', [SettingController::class,'edit'])->name('setting.index');
    Route::post('setting', [SettingController::class,'update'])->name('setting.update');
});


require __DIR__.'/auth.php';
