<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use Rap2hpoutre\FastExcel\FastExcel;

Route::get("/testexcel", function () {
    $arrayVal = [
        0 => [
            "id" => 1,
            "name" => "popo"
        ],
        1 => [
            "id" => 2,
            "name" => "pepa"
        ],
        2 => [
            "id" => 3,
            "name" => "peems"
        ]
    ];

    return (new FastExcel($arrayVal))->download('file.xlsx');
});

Route::get('/', [HomeController::class, "index"])->name("home");

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('login_check');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerCheck'])->name('register');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {


    Route::get('/home', [AdminController::class, 'home'])->name('admin_home')->middleware(['role:admin']);
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin_logout');

    //Users
    Route::post('/find-user', [AdminController::class, 'findUser'])->name('admin_find_user');
    Route::post('/update-user', [AdminController::class, 'updateUser'])->name('admin_update_user');
    Route::post('/delete-user', [AdminController::class, 'deleteUser'])->name('admin_delete_user');
    Route::get('/user-approve/{id}', [AdminController::class, 'userApprove'])->name('admin_user_approve')->middleware(['role:admin']);

    //Bus

    Route::get('/bus', [AdminController::class, 'bus'])->name('admin_bus');
    Route::get('/bus-package/{id}', [AdminController::class, 'busPackage'])->name('admin_bus_package');
    Route::post('/bus', [AdminController::class, 'bus_check'])->name('admin_bus_check');
    Route::post('/find-bus', [AdminController::class, 'findBus'])->name('admin_find_bus');
    Route::post('/update-bus', [AdminController::class, 'updateBus'])->name('admin_update_bus');
    //Route::post('/delete-bus',[AdminController::class, 'deleteBus'])->name('admin_delete_bus');

    //packages
    Route::post('/bus-packge', [AdminController::class, 'busPackageCheck'])->name('admin_bus_package_check');

    //Booking
    Route::get('/admin-booking-list', [AdminController::class, 'bookingList'])->name('admin_booking_list');
    Route::post('/admin-booking-set-date', [AdminController::class, 'bookingSetDate'])->name('admin_set_date');
    Route::get('/admin-booking-cancel/{id}', [AdminController::class, 'bookingCancel'])->name('admin_booking_cancel');
    Route::get('/admin-booking-approve/{id}', [AdminController::class, 'bookingApprove'])->name('admin_booking_approve');
    Route::post('/admin-booking-payment', [AdminController::class, 'bookingPayment'])->name('admin_payment');
    Route::post('/admin-find-booking', [AdminController::class, 'findBooking'])->name('admin_find_booking');

    //Sales
    Route::get('/sales', [AdminController::class, 'sales'])->name('admin_sales');
    Route::get('/report', [AdminController::class, 'report'])->name('admin_report');


    //Customer
    Route::get('/booking', [AdminController::class, 'customer_booking_packages'])->name('customer_booking_packages');
    Route::get('/booking-list', [AdminController::class, 'customer_booking_list'])->name('customer_booking_list');
    Route::get('/feedback', [FeedbackController::class, "create"])->name("feedback.create");
    Route::post('/feedback', [FeedbackController::class, "store"])->name("feedback.store");
    Route::get('/feedback/{booking}', [FeedbackController::class, "show"])->name("feedback.show");

    Route::get('/notifications', [NotificationController::class, "index"])->name("notifications");
});