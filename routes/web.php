<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\StoreController;  
use App\Http\Controllers\ProductController;
use App\Models\Store;




Route::get('/kanjeng-mami', [StoreController::class, 'showKanjengMami'])->name('kanjeng.mami');
Route::post('/toggle-status', [StoreController::class, 'toggleStatus'])->name('toggle.status');

// routes/web.php  

// routes/web.php  

Route::get('/kanjeng-mami/products', [StoreController::class, 'products'])->name('mitra.products');  
Route::get('/mitra/products/{id}', [StoreController::class, 'detailProduct'])->name('mitra.product.detail');

// routes/web.php  

use App\Http\Controllers\AdminController;  
use App\Http\Controllers\ClientController;  
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ActuatorController;

use App\Http\Controllers\EnergyCostController;  
use App\Http\Controllers\AdminPackageController;

// Admin Routes  
use App\Http\Controllers\SensorDataController;  
use App\Http\Controllers\OrderController;




Route::get('admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.register');  
Route::post('admin/register', [AdminController::class, 'register']);  
Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');  
Route::post('admin/login', [AdminController::class, 'login']);  
Route::middleware('auth:admin')->group(function () {  
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');  
    Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');  
    Route::get('/dashboard/create', [ProductController::class, 'create'])->name('admin.products.create');  
    Route::post('/dashboard/store', [ProductController::class, 'store'])->name('admin.products.store');  
    Route::get('/dashboard/data', [ProductController::class, 'index'])->name('admin.products.read'); 
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');  
    Route::put('/dashboard/{id}', [ProductController::class, 'update'])->name('admin.products.update');  
    Route::delete('/dashboard/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy'); 
    Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');
    Route::get('admin/dashboard/task', [StoreController::class, 'showTugas'])  
    ->name('admin.task');  

    Route::post('/admin/dashboard/task/toggle', [StoreController::class, 'toggleStatus'])  
        ->name('toggle.status');  

    Route::post('/admin/dashboard/task/relay', [StoreController::class, 'toggleRelay'])  
    ->name('actuator.toggle');
    // Route::get('/dashboard', function(){
    //     $title = "Profil";
    //     $agent = new \Jenssegers\Agent\Agent();
    //     $isMobile = $agent->isMobile();
    //     return view('products.profil', compact('title', 'isMobile'));
    // });
    Route::get('/admin/carts', [AdminController::class, 'viewAllCarts'])->name('admin.carts.index');   
    Route::get('/admin/carts/{clientId}', [AdminController::class, 'viewClientCart'])->name('admin.carts.show'); 
    Route::get('/admin/profile/{clientId}', [AdminController::class, 'viewClientProfile'])->name('admin.carts.profile'); 
    Route::get('/admin/clients/{client}', [AdminController::class, 'clientOrders'])->name('admin.carts.orders');

    Route::get('/admin/clients/{client}/orders', [AdminController::class, 'clientOrderDetails'])->name('admin.client.order.details');

    Route::patch('/order/{orderId}/update-status',   
    [OrderController::class, 'updateStatus'])  
    ->name('order.update.status');

    Route::get('/admin/monitoring', [SensorDataController::class, 'index'])->name('admin.monitoring.index');
    Route::get('/api/sensor-data', [SensorDataController::class, 'getSensorData']);
    Route::get('/api/cost-data', [SensorDataController::class, 'getCostData']);

    Route::prefix('admin/packages')->name('admin.packages.')->group(function () {  
        Route::get('/', [AdminPackageController::class, 'index'])->name('index');  
        Route::get('/create', [AdminPackageController::class, 'create'])->name('create');  
        Route::post('/', [AdminPackageController::class, 'store'])->name('store');  
        Route::get('/{package}/edit', [AdminPackageController::class, 'edit'])->name('edit');  
        Route::put('/{package}', [AdminPackageController::class, 'update'])->name('update');  
        Route::delete('/{package}', [AdminPackageController::class, 'destroy'])->name('destroy'); // Perbaikan di sini
        Route::get('/{package}', [AdminPackageController::class, 'show'])->name('show');  
    });
});

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;  

// Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');  
// Route::post('/payment/midtrans', [PaymentController::class, 'makePayment'])->name('payment.make');  
// Route::post('/payment/midtrans/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification');   
// Client Routes  


use App\Http\Controllers\ClientPackageController;
Route::get('client/register', [ClientController::class, 'showRegisterForm'])->name('client.register');  
Route::post('client/register', [ClientController::class, 'register']);  
Route::get('client/login', [ClientController::class, 'showLoginForm'])->name('client.login');  
Route::post('client/login', [ClientController::class, 'login']);  
Route::middleware('auth:client')->group(function () {  
    Route::get('client/dashboard', [ClientController::class, 'dashboard'])->name('client.profil');  
    Route::post('client/logout', [ClientController::class, 'logout'])->name('client.logout'); 
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');  
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');  
    Route::post('/cart/update/{cartId}', [CartController::class, 'updateQuantity'])->name('cart.update');  
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'removeFromCart'])->name('cart.remove'); 

    Route::post('/cart/checkout', [PaymentController::class, 'checkout'])->name('cart.checkout');
    Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
    
    Route::prefix('packages')->name('client.packages.')->group(function () {  
        Route::get('/', [ClientPackageController::class, 'index'])->name('index');  
        Route::post('/{package}/add-to-cart', [ClientPackageController::class, 'addToCart'])  
            ->name('addToCart');  
    });  


    Route::get('client/edit-profile', [ClientController::class, 'editProfile'])->name('client.edit-profile');  
    Route::put('client/update-profile', [ClientController::class, 'updateProfile'])->name('client.update-profile'); 
});

// Route::fallback(function () {  
//     return view('errors.404'); // Buat file di resources/views/errors/404.blade.php  
// });



