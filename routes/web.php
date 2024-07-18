<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllProductsController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Bakery\BakeryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CorporateOrderController;
use App\Http\Controllers\Bakery\BContactUsController;
use App\Http\Controllers\CakeCustomisationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SubscriberController;


Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/about-us', [HomeController::class, 'about'])->name('about-us');
Route::get('subscribe', [SubscriberController::class, 'showSubscribeForm'])->name('subscribe.form');
Route::post('subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');
Route::post('unsubscribe', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');
Route::get('/application/create', [ApplicationController::class, 'showForm'])->name('application.create');
Route::post('/application', [ApplicationController::class, 'store']);
Route::get('/contactus/create', [ContactUsController::class, 'showForm'])->name('contactus.create');
Route::post('/contactus', [ContactUsController::class, 'store']);
Route::get('/home',[HomeController::class,'index']);
Route::get('/faq',[HomeController::class,'faq'])->name('faq');
Route::get('/allproducts', [AllProductsController::class, 'index'])->name('showallproduct');
Route::get('/allproducts/{id}', [AllProductsController::class, 'show']);

Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

Route::get('/anniversary', [AllProductsController::class, 'anniversary'])->name('anniversary');
Route::get('/christmas', [AllProductsController::class, 'christmas'])->name('christmas');
Route::get('/klselangor', [AllProductsController::class, 'klselangor']);
Route::get('/penang', [AllProductsController::class, 'penang']);
Route::get('/jb', [AllProductsController::class, 'jb']);
Route::get('/5hours', [AllProductsController::class, 'fivehours']);
Route::get('/1day', [AllProductsController::class, 'oneday']);
Route::get('/2days', [AllProductsController::class, 'twodays']);
Route::get('/3days', [AllProductsController::class, 'threedays']);
Route::get('/selfcollect', [AllProductsController::class, 'selfcollect']);
Route::get('/result', [AllProductsController::class, 'search'])->name('search');
Route::get('/bakeries', [BakeryController::class, 'bakeryList'])->name('bakeries.list');
Route::get('/bakeries/{id}', [BakeryController::class, 'showBakery'])->name('bakeries.profile');

Route::get('/customise-cake', [CakeCustomisationController::class, 'showCustomisationForm'])->name('cakecustomisation.form');
Route::post('/customise-cake', [CakeCustomisationController::class, 'submitCustomisationForm'])->name('cakecustomisation.submit');

Route::get('/corporate-order', [CorporateOrderController::class, 'showCorporateOrderForm'])->name('corporateOrder');
Route::post('/corporate-order', [CorporateOrderController::class, 'storeCorporateOrderForm'])->name('corporateOrder.store');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

//User Routes
Route::middleware(['auth','user'])->group(function(){
    Route::get('/dashboard',[UserController::class, 'index'])->name('dashboard');
    Route::get('/user/coupons', [UserController::class, 'showUserCoupons'])->name('coupons');
    Route::get('/favourite',[WishlistController::class, 'list'])->name('fav.list');

    Route::post('/store/{id}', [CartController::class, 'store'])->name('cart.store')->middleware('verified');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::get('/cart/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/cart/update/{id}', [CartController::class, 'updateOrderItems'])->name('cart.updateOrderItems');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/check-coupon', [CartController::class, 'checkCoupon'])->name('cart.checkCoupon');
    Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
    Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('cart.processCheckout');
    Route::get('/payment', [OrderController::class, 'showPaymentPage'])->name('paymentPage');
    Route::get('/order-success/{orderId}', [OrderController::class, 'showSuccessPage'])->name('order.success');
    Route::get('/orders',[OrderController::class, 'list'])->name('orders.list');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/cancel-order', [CartController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/order-cancelled/{order}', [CartController::class, 'showCancelledOrder'])->name('orders.cancelled');
    Route::delete('/order/delete', [OrderController::class, 'deleteOrder'])->name('order.delete');
    Route::get('/reviews', [ReviewController::class, 'showUserReviews'])->name('reviews');
    Route::get('/loyalty', [UserController::class, 'showLoyaltyPage'])->name('loyalty.page');
    Route::post('/redeem-points', [UserController::class, 'redeemPoints'])->name('redeem.points');
});

//Admin Routes
Route::middleware(['auth','admin'])->group(function(){
    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/userlist',[AdminController::class, 'userlist'])->name('admin.userlist');
    Route::get('/admin/bakerylist',[AdminController::class, 'bakerylist'])->name('admin.bakerylist');
    Route::get('/admin/userresult', [AdminController::class, 'usersearch'])->name('admin.usersearch');
    Route::get('/admin/bakeryresult', [AdminController::class, 'bakerysearch'])->name('admin.bakerysearch');
    Route::get('/admin/enquirylist',[AdminController::class, 'enquirylist'])->name('admin.enquirylist');
    Route::get('/admin/userenquiry',[AdminController::class, 'userenquiry'])->name('admin.userenquiry');
    Route::get('/admin/bakeryenquiry',[AdminController::class, 'bakeryenquiry'])->name('admin.bakeryenquiry');
    Route::get('/admin/result', [AdminController::class, 'enquirysearch'])->name('admin.enquirysearch');
    Route::get('/admin/user/enquiryresult', [AdminController::class, 'uenquirysearch'])->name('admin.uenquirysearch');
    Route::get('/admin/bakery/enquiryresult', [AdminController::class, 'benquirysearch'])->name('admin.benquirysearch');
    Route::get('/admin/enquiry/{id}/{type}', [AdminController::class, 'showenquiry'])->name('admin.showenquiry');
    Route::get('/admin/enquiry/user/{id}/{type}', [AdminController::class, 'showuseren'])->name('admin.showuseren');
    Route::get('/admin/enquiry/bakery/{id}/{type}', [AdminController::class, 'showbakeryen'])->name('admin.showbakeryen');
    Route::put('/admin/update-enquiry-status/{id}/{type}', [AdminController::class, 'updateEnquiryStatus'])->name('admin.updateEnquiryStatus');

    Route::get('/admin/user/{id}', [AdminController::class, 'showUser'])->name('admin.showUser');
    Route::get('/admin/user/{id}/edit', [AdminController::class, 'edit'])->name('admin.user.edit');
    Route::put('/admin/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');

    Route::get('/admin/bakery/{id}', [AdminController::class, 'showBakery'])->name('admin.showBakery');
    Route::get('/admin/bakery/{id}/edit', [AdminController::class, 'bakeryedit'])->name('admin.bakery.edit');
    Route::put('/admin/bakery/{id}', [AdminController::class, 'updateBakery'])->name('admin.bakery.update');
    Route::delete('/admin/bakery/{id}', [AdminController::class, 'destroyBakery'])->name('admin.bakery.destroy');

    Route::get('/admin/bakeryapplicationlist',[AdminController::class, 'bakeryApplicationList'])->name('admin.bakeryApplicationList');
    Route::get('/admin/bakery/application/{id}', [AdminController::class, 'showApplication'])->name('admin.showApplication');
    Route::put('/admin/update-application-status/{id}/', [AdminController::class, 'updateApplicationStatus'])->name('admin.updateApplicationStatus');
    Route::get('/admin/search-application-result', [AdminController::class, 'applicationSearch'])->name('admin.applicationSearch');

    Route::get('/admin/corporate-orders',[CorporateOrderController::class, 'corporateOrderList'])->name('corporateOrders.list');
    Route::get('/admin/corporate-orders/{id}', [CorporateOrderController::class, 'corporateOrderDetails'])->name('corporateOrders.show');
    Route::put('/admin/update-corporate-orders/{id}', [CorporateOrderController::class, 'updateCorporateOrderStatus'])->name('corporateOrders.update');
    Route::get('/admin/corporate-order-result', [CorporateOrderController::class, 'corporateOrderSearch'])->name('corporateOrders.search');

    Route::get('/admin/newsletter', [NewsletterController::class, 'showNewsletterForm'])->name('admin.newsletter.form');
    Route::post('/admin/newsletter', [NewsletterController::class, 'sendNewsletter'])->name('admin.newsletter.send');

    Route::get('/admin/bloglist', [AdminController::class, 'bloglist'])->name('admin.bloglist');
    Route::get('/admin/blog/{slug}', [AdminController::class, 'viewblog'])->name('admin.viewblog');
    Route::delete('/admin/blog/{id}', [AdminController::class, 'destroyBlog'])->name('admin.blog.destroy');

    Route::get('/admin/blog/edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/admin/blog/update/{id}', [BlogController::class, 'update'])->name('admin.blog.update');
});

//Bakery Routes
Route::middleware(['auth','bakery'])->group(function(){
    Route::get('/bakery/dashboard',[BakeryController::class, 'index'])->name('bakery.dashboard');
    Route::get('/bakery/viewproduct/{id}', [BakeryController::class, 'view'])->name('bakery.viewproduct');
    Route::get('/bakery/editproduct/{id}', [BakeryController::class, 'editproduct'])->name('bakery.editproduct');
    Route::post('/bakery/updateproduct/{id}', [BakeryController::class, 'updateproduct'])->name('bakery.updateproduct');
    Route::delete('/bakery/editproduct/{id}', [BakeryController::class, 'destroy'])->name('bakery.deleteproduct');
    Route::get('/bakery/createproduct',[BakeryController::class, 'create'])->name('bakery.createproduct');
    Route::post('/bakery/store', [BakeryController::class, 'store']);

    Route::get('/bakery/listproduct',[BakeryController::class, 'list'])->name('bakery.listproduct');
    Route::post('/bakery/update-visibility/{id}', [BakeryController::class, 'updateVisibility'])->name('bakery.updateVisibility');
    Route::get('/bakery/contactus/create', [BContactUsController::class, 'showForm'])->name('bakerycontactus.create');
    Route::post('/bakery/contactus', [BContactUsController::class, 'store']);

    Route::get('/bakery/orderlist',[BakeryController::class, 'orderlist'])->name('bakery.orderlist');
    Route::get('/bakery/orders/pending', [BakeryController::class, 'pendingOrders'])->name('bakery.orders.pending');
    Route::get('/bakery/orders/ready', [BakeryController::class, 'readyOrders'])->name('bakery.orders.ready');
    Route::get('/bakery/orders/upcoming', [BakeryController::class, 'upcomingOrders'])->name('bakery.orders.upcoming');
    Route::get('/bakery/orders/completed', [BakeryController::class, 'completedOrders'])->name('bakery.orders.completed');
    Route::get('/bakery/orders/result', [BakeryController::class, 'search'])->name('bakery.orders.search');
    Route::get('/bakery/orders/{id}', [BakeryController::class, 'show'])->name('bakery.orders.show');
    Route::put('/bakery/orders/{order}/update-status', [BakeryController::class, 'updateStatus'])->name('bakery.orders.updateStatus');

    Route::get('/bakery/custom-orders', [BakeryController::class, 'showCustomOrders'])->name('bakery.custom.orders');
    Route::get('/bakery/custom-orders/{id}', [BakeryController::class, 'showCustomOrderDetails'])->name('bakery.custom.show');
    Route::put('/bakery/custom-orders/{id}/update-status', [BakeryController::class, 'updateCustomOrderStatus'])->name('bakery.customOrders.updateStatus');

    Route::get('/bakery/manage-categories', [BakeryController::class, 'showManageCategories'])->name('bakery.manageCategories');
    Route::post('/bakery/add-category', [BakeryController::class, 'addCategory'])->name('bakery.addCategory');

    Route::get('/bakery/reviews', [BakeryController::class, 'showBakeryReviews'])->name('bakery.reviews');

    Route::get('/bakery/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/bakery/blog/create', [BlogController::class, 'store'])->name('blog.store');
});
