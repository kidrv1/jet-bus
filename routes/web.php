<?php

use App\Mail\OTP;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Service\NotifService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PackageAddonController;
use App\Http\Controllers\CancelRequestController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\SatisfiedCustomerController;
use App\Http\Controllers\ReportPdfController;

Route::get('/', [HomeController::class, "index"])->name("home");

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('login_check');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerCheck'])->name('register');

Route::get('/contact', [ContactMessageController::class, 'create'])->name('contact');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::get('/our-services', [HomeController::class, 'services'])->name('services');

Route::get("/packages/{id?}", [PackageController::class, "show"])->name("packages.show");
Route::get("/packages_list", [AdminController::class, "public_packages"])->name("public.packages");

// Email Verification
Route::get('/email/verify', [AuthController::class, 'verify'])->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify_confirm'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'verify_resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {

    Route::get("cart-count", [CartController::class, 'count'])->name("cart.count");
    Route::get("my-cart", [CartController::class, 'index'])->name("my_cart");
    Route::post("my-cart", [CartController::class, 'add'])->name("cart.add");
    Route::get("my-cart/delete/{id?}", [CartController::class, 'remove'])->name("cart.remove");
    Route::get("checkout", [CartController::class, 'checkout'])->name("cart.checkout");

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
    Route::post('/update-bus-status', [AdminController::class, 'busUpdateStatus'])->name('admin_bus_status');

    //Route::post('/delete-bus',[AdminController::class, 'deleteBus'])->name('admin_delete_bus');

    //packages
    Route::post('/bus-packge', [AdminController::class, 'busPackageCheck'])->name('admin_bus_package_check');
    Route::post('/find-package', [PackageController::class, 'find'])->name('admin_find_package');
    Route::post('/update-package', [PackageController::class, 'update'])->name('admin_update_package');
    Route::post('/update-package-status', [PackageController::class, 'updateStatus'])->name('admin_update_package_status');

    //Booking
    Route::get('/admin-booking-list', [AdminController::class, 'bookingList'])->name('admin_booking_list');
    Route::post('/admin-booking-set-date', [AdminController::class, 'bookingSetDate'])->name('admin_set_date');
    Route::put('/admin-booking-cancel', [CancelRequestController::class, 'update'])->name('admin_booking_cancel_approve');
    Route::get('/admin-booking-cancel-admin/{id}', [AdminController::class, 'bookingCancel'])->name('admin_booking_cancel');
    Route::get('/admin-booking-approve/{id}', [AdminController::class, 'bookingApprove'])->name('admin_booking_approve');
    Route::get('/admin-booking-complete/{id}', [AdminController::class, 'bookingComplete'])->name('admin_booking_complete');
    Route::post('/admin-booking-payment', [AdminController::class, 'bookingPayment'])->name('admin_payment');
    Route::post('/admin-find-booking', [AdminController::class, 'findBooking'])->name('admin_find_booking');

    //Sales
    Route::get('/sales', [AdminController::class, 'sales'])->name('admin_sales');
    Route::get('/report', [AdminController::class, 'report'])->name('admin_report');

    // Feedbacks
    Route::get('/customer-feedbacks', [FeedbackController::class, 'index'])->name('admin_feedback');

    // Inbox
    Route::get('/inbox', [ContactMessageController::class, 'index'])->name('admin_inbox');
    Route::put('/inbox/{msg_id?}', [ContactMessageController::class, 'update'])->name('admin_inbox.update');

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('admin_calendar_index');

    // Testimonials
    Route::get('/testimonials', [SatisfiedCustomerController::class, 'index'])->name('admin_testimonials_index');
    Route::post('/testimonials', [SatisfiedCustomerController::class, 'store'])->name('admin_testimonials_store');
    Route::post('/testimonials/delete', [SatisfiedCustomerController::class, 'destroy'])->name('admin_testimonials_delete');

    // Package Addons
    Route::get('/package-addons/{package_id?}', [PackageAddonController::class, 'index'])->name('admin_package_addons.index');
    Route::get('/package-addons/create/{addon_id?}', [PackageAddonController::class, 'show'])->name('admin_package_addons.show');
    Route::post('/package-addons', [PackageAddonController::class, 'store'])->name('admin_package_addons.create');
    Route::put('/package-addons', [PackageAddonController::class, 'update'])->name('admin_package_addons.update');
    Route::delete('/package-addons', [PackageAddonController::class, 'destroy'])->name('admin_package_addons.delete');

    // Stats
    Route::get('/stats', [StatController::class, 'index'])->name('admin_stats_index');

    //Customer
    // Booking Cancellation
    Route::get('/booking-cancel-request/{id?}', [CancelRequestController::class, 'show'])->name('customer_booking_cancel_show');
    Route::post('/booking-cancel-request', [CancelRequestController::class, 'store'])->name('customer_booking_cancel_request');

    // Route::get('/booking', [AdminController::class, 'customer_booking_packages'])->name('customer_booking_packages');
    Route::redirect('/booking', '/#featured-section', 301)->name('customer_booking_packages');

    Route::get('/booking-list', [AdminController::class, 'customer_booking_list'])->name('customer_booking_list');
    Route::get('/feedback', [FeedbackController::class, "create"])->name("feedback.create");

    Route::post('/feedback', [FeedbackController::class, "store"])->name("feedback.store");

    Route::get('/notifications', [NotificationController::class, "index"])->name("notifications");
    Route::put("/notifications", [NotificationController::class, "update"])->name("notifications.update");
    Route::get("/notifications_count", [NotificationController::class, "unreadCount"])->name("notifications.unreadCount");
    Route::get("/notifications_unread", [NotificationController::class, "unread"])->name("notifications.unread");


    Route::get("/latest-registered/{type}",[ReportPdfController::class,'LatestUsers'])->name('admin_latest_user');
    Route::get("/latest-sales/{type}",[ReportPdfController::class,'salesReport'])->name('admin_latest_sale');
    Route::get("/latest-popular/{type}",[ReportPdfController::class,'popularReport'])->name('admin_latest_popular');

    Route::get("/latest-registered-xls/{type}",[ReportPdfController::class,'LatestUsersXLS'])->name('admin_latest_user_xls');
    Route::get("/latest-sales-xls/{type}",[ReportPdfController::class,'salesReportXLS'])->name('admin_latest_sale_xls');
    Route::get("/latest-popular-xls/{type}",[ReportPdfController::class,'popularReportXLS'])->name('admin_latest_popular_xls');
});


// Test Routes
Route::get("/verify-users", function () {
    $user = User::find(1);
    $user->email_verified_at = now();
    $user->save();

    return User::find(1);
});
// Route::get("/testexcel", function () {
//     // $arrayVal = [
//     //     0 => [
//     //         "id" => 1,
//     //         "name" => "popo"
//     //     ],
//     //     1 => [
//     //         "id" => 2,
//     //         "name" => "pepa"
//     //     ],
//     //     2 => [
//     //         "id" => 3,
//     //         "name" => "peems"
//     //     ]
//     // ];

//     // return (new FastExcel($arrayVal))->download('file.xlsx');

//     $monthDays = [];
//     $monthPeriod = CarbonPeriod::create(now()->startOfMonth(), now()->endOfMonth());
//     foreach ($monthPeriod as $date) {
//         $monthDays[] = $date->format('d');
//     }

//     return response()->json(["days_in_month" => $monthDays], 200);
// });

// Route::get("/notif-me", function () {

//     Log::debug("Accessed Notif Route");
//     if (auth()->check()) {
//         Log::debug("Created Notif");
//         (new NotifService())->sendNotification(
//             auth()->id(),
//             "Test Notif",
//             "This is a test notification"
//         );
//     }

//     return redirect()->home();
// });

// Route::get("/month", function () {
//     $month = now()->startOfYear()->format('m');

//     return $month;
// });


// Route::get("/test-email", function () {
//     $email = "youremailhere@example.com";
//     Mail::to($email)->send(new OTP($email));

//     return response()->json(["message" => "test email sent"], 200);
// });