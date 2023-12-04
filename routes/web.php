<?php

use App\Http\Controllers\AdminCategoryController;
use App\Models\Category;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardBlogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;


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
    return view('home', [
        "tittle" => "Home",
        "active" => 'home',
    ]);
});
Route::get('/about', function () {
    return view('about', [
        "tittle" => "About",
        "active" => 'about',
        "nama" => " Adnan Rais Purnomo",
        "email" => "adnanrais@gmail.com",
        "gambar" => "adnan.jpg"
    ]);
});

Route::get('/blogs', [BlogController::class, 'index']);
Route::get('blogs/{blog:slug}', [BlogController::class, 'show']);

Route::get('/categories', function() {
    return view('categories', [
        'tittle' => 'Blog categories',
        'active' => 'categories',
        'categories' => Category::all()
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard',  function() {
    return view('dashboard.index');
})->middleware('auth');

Route::get('/dashboard/blogs/checkSlug',[DashboardBlogController::class, 'checkSlug'])-> middleware('auth');
Route::resource('/dashboard/blogs', DashboardBlogController::class)->middleware('auth');

Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');

