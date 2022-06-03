<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DropzoneController;
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
Auth::routes();
Route::get('/', function () {
    return view('index');
})->name('index');

// Validation route

Route::get('/validate-email',[UserController::class,'validateUserEmail'])->name('validateEmail');
Route::get('/validate-username',[UserController::class,'validateUsername'])->name('validateUsername');

// Admin route

Route::prefix('admin')->middleware(['auth', 'auth.isAdmin','verified'])->name('admin.')->group(function (){
    Route::get('get-more-users',[UserController::class,'getMoreUsers'])->name('getMoreUsers');
    Route::resource('/users',UserController::class);
});

// Comments route
Route::prefix('announcement')->middleware(['auth', 'auth.hasAnyRoles'])->group(function (){
    Route::post('/comment', [CommentController::class,'store'])->name('createComment');
    Route::delete('/comment/delete/{id}', [CommentController::class,'destroy'])->name('deleteComment');
    Route::get('/comment/edit/{id}', [CommentController::class,'edit'])->name('editComment');
    Route::put('/comment/store/{id}', [CommentController::class,'update'])->name('storeComment');
});

Route::post('/comment',[CommentController::class,'create'])->name('comment');

//Announcements
Route::get('get-more-users', [AnnouncementController::class,'getMoreAnnouncements'])->name('announcements.get-more-announcements');
Route::get('/announcements',[AnnouncementController::class,'index'])->name('announcements');
Route::get('/announcements/manage',[AnnouncementController::class,'manageAnnouncements'])->name('announcements.manage');
Route::resource('/announcements',AnnouncementController::class);
Route::delete('/deleteimage/{id}',[AnnouncementController::class,'deleteImage'])->name('announcement.deleteImage');
Route::delete('/deletecover/{id}',[AnnouncementController::class,'deleteCover'])->name('announcement.deleteCover');

//Profile
Route::get('/profile/{id}',[ProfileController::class,'index'])->name('profile');
Route::get('/myreservations',[ProfileController::class,'userReservations'])->name('profile.myReservations');
Route::get('/edit/profile/{id}',[ProfileController::class,'editProfile'])->name('profile.editProfile');
Route::post('/edit/profile',[ProfileController::class,'updateProfile'])->name('profile.updateProfile');
Route::delete('/cancel/reservation/{id}',[ProfileController::class,'cancelReservation'])->name('profile.cancelReservation');
//
Route::get('/home', [HomeController::class, 'index'])->name('home');


//SHOP ROUTES

Route::get('/shop', [ProductController::class,'index'])->name('shop');
Route::post('/shop', [ProductController::class,'store'])->name('storeProduct');
Route::get('/add-to-cart/{id}',[ProductController::class,'getAddToCart'])->name('addToCart');
Route::get('/shopping-cart',[ProductController::class,'getCart'])->name('shoppingCart');
Route::get('/checkout',[ProductController::class,'getCheckout'])->middleware(['auth', 'auth.hasAnyRoles'])->name('checkout');
Route::post('/checkout',[ProductController::class,'postCheckout'])->middleware(['auth', 'auth.hasAnyRoles'])->name('checkout');
Route::get('reduceByOne/{id}',[ProductController::class,'getReduceByOne'])->name('reduceByOne');
Route::get('removeItem/{id}',[ProductController::class,'getRemoveItem'])->name('removeItem');
Route::get('/shop/show/{id}', [ProductController::class,'show'])->name('shop.show');
Route::get('get-more-products', [ProductController::class,'getMoreProducts'])->name('shop.get-more-products');

Route::middleware(['auth', 'auth.isOwner'])->group(function (){
    Route::get('/shop/add', [ProductController::class,'create'])->name('addProduct');
    Route::get('/orders',[ProductController::class,'orderList'])->name('shop.getOrdersList');
    Route::get('/order/{id}',[ProductController::class,'showOrder'])->name('shop.showOrder');
    Route::put('/approve/{id}',[ProductController::class,'approved'])->name('shop.approve');
    Route::put('/sent/{id}',[ProductController::class,'sent'])->name('shop.sent');
});

//RESERVATIONS ROUTE

Route::get('/reservations',[ReservationController::class,'index'])->name('reservations.index');
Route::post('/reservations',[ReservationController::class,'store'])->name('reservations.store');
Route::get('get-more-reservations', [ReservationController::class,'getMoreReservations'])->name('reservations.get-more-reservations');
Route::get('/reservations/prepayment',[ReservationController::class,'getPrepayment'])->name('reservations.Prepayment');
Route::post('/reservations/prepayment',[ReservationController::class,'postPrepayment'])->name('reservations.Prepayment');

Route::middleware(['auth', 'auth.isStaff'])->group(function () {
    Route::get('/reservations/list', [ReservationController::class, 'reservetionsList'])->name('reservations.list');
    Route::get('get-reservations-list', [ReservationController::class, 'getReservationsList'])->name('reservations.getReservationsList');
    Route::get('get-reservation-info', [ReservationController::class, 'show'])->name('reservations.getReservationInfo');
});

Route::post('dropzone/upload', [DropzoneController::class,'upload'])->name('dropzone.upload');
