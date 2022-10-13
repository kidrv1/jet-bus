<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('login_check');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerCheck'])->name('register');

Route::group(['prefix'=> 'dashboard','middleware'=> ['auth']], function(){

    
    Route::get('/home',[AdminController::class, 'home'])->name('admin_home')->middleware(['role:admin']);
    Route::get('/logout',[AdminController::class, 'logout'])->name('admin_logout');

    //Users
    Route::post('/find-user',[AdminController::class, 'findUser'])->name('admin_find_user');
    Route::post('/update-user',[AdminController::class, 'updateUser'])->name('admin_update_user');
    Route::post('/delete-user',[AdminController::class, 'deleteUser'])->name('admin_delete_user');

    //Bus

    Route::get('/bus',[AdminController::class, 'bus'])->name('admin_bus');
    Route::get('/bus-package/{id}',[AdminController::class, 'busPackage'])->name('admin_bus_package');
    Route::post('/bus',[AdminController::class, 'bus_check'])->name('admin_bus_check');
    Route::post('/find-bus',[AdminController::class, 'findBus'])->name('admin_find_bus');
    Route::post('/update-bus',[AdminController::class, 'updateBus'])->name('admin_update_bus');
    //Route::post('/delete-bus',[AdminController::class, 'deleteBus'])->name('admin_delete_bus');

    //packages
    Route::post('/bus-packge',[AdminController::class, 'busPackageCheck'])->name('admin_bus_package_check');

    //Booking
    Route::get('/admin-booking-list',[AdminController::class, 'bookingList'])->name('admin_booking_list');

    //Sales
    Route::get('/sales',[AdminController::class, 'sales'])->name('admin_sales');


    //Customer
    Route::get('/booking',[AdminController::class, 'customer_booking_packages'])->name('customer_booking_packages');
    Route::get('/booking-list',[AdminController::class, 'customer_booking_list'])->name('customer_booking_list');



    
});

