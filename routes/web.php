<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\App\Frontend\Homes\HomeIndex;
use App\Livewire\App\Frontend\Carts\CartIndex;
use App\Livewire\App\Authentications\LoginIndex;
use App\Livewire\App\Authentications\Passwords\{ForgotIndex, ConfirmIndex, ResetIndex};
use App\Livewire\App\Authentications\RegisterIndex;
use App\Livewire\App\Backend\Admin\Billings\{BillingIndex, BillingDetail};
use App\Livewire\App\Backend\Customer\Dashboards\DashboardIndex as CustomerDashboardIndex;
use App\Livewire\App\Backend\Customer\Billings\BillingIndex as CustomerBillingIndex;
use App\Livewire\App\Backend\Customer\Billings\BillingDetail as CustomerBillingDetail;
use App\Livewire\App\Backend\Customer\Orders\OrderIndex as CustomerOrderIndex;
use App\Livewire\App\Backend\Customer\Orders\OrderDetail as CustomerOrderDetail;
use App\Livewire\App\Backend\Customer\UserManagements\UserManagementIndex as CustomerUserManagementIndex;
use App\Livewire\App\Backend\Admin\Dashboards\DashboardIndex as AdminDashboardIndex;
use App\Livewire\App\Backend\Admin\Equipments\EquipmentIndex as AdminEquipmentIndex;
use App\Livewire\App\Backend\Admin\Orders\{OrderIndex, OrderDetail};
use App\Livewire\App\Backend\Admin\PaymentMethods\PaymentMethodIndex;
use App\Livewire\App\Backend\Admin\UserManagements\UserManagementIndex;
use App\Livewire\App\Frontend\Equipments\EquipmentIndex;

Route::get('/', HomeIndex::class)->name('home');
Route::get('/equipment', EquipmentIndex::class)->name('equipment');
Route::get('/cart', CartIndex::class)->name('cart');

Route::prefix('/auth')->middleware(['guest', 'prevent_back_history'])->name('auth.')->group(function () {
    Route::get('/login', LoginIndex::class)->name('login');
    Route::get('/register', RegisterIndex::class)->name('register');

    Route::prefix('/password')->name('password.')->group(function () {
        Route::get('/forgot', ForgotIndex::class)->name('forgot');
        Route::get('/confirm/{email}', ConfirmIndex::class)->name('confirm');
        Route::get('reset-password/{token}', ResetIndex::class)->name('reset');
    });
});

Route::prefix('/customer-area')->middleware(['auth', 'prevent_back_history'])->name('customer_area.')->group(function () {
    Route::get('/dashboard', CustomerDashboardIndex::class)->name('dashboard');
    Route::prefix('/billings')->name('billing.')->group(function () {
        Route::get('/index', CustomerBillingIndex::class)->name('index');
        Route::get('/detail/{orderCode}', CustomerBillingDetail::class)->name('detail');
    });
    Route::prefix('/orders')->name('order.')->group(function () {
        Route::get('/index', CustomerOrderIndex::class)->name('index');
        Route::get('/detail/{orderCode}', CustomerOrderDetail::class)->name('detail');
    });
    Route::get('/user-managements/index', CustomerUserManagementIndex::class)->name('user_management.index');
});

Route::prefix('/admin-area')->middleware(['auth', 'prevent_back_history'])->name('admin_area.')->group(function () {
    Route::get('/dashboard', AdminDashboardIndex::class)->name('dashboard');
    Route::get('/equipments/index', AdminEquipmentIndex::class)->name('equipment.index');
    Route::get('/payment-methods/index', PaymentMethodIndex::class)->name('payment_method.index');
    Route::prefix('/billings')->name('billing.')->group(function () {
        Route::get('/index', BillingIndex::class)->name('index');
        Route::get('/detail/{orderCode}', BillingDetail::class)->name('detail');
    });
    Route::prefix('/orders')->name('order.')->group(function () {
        Route::get('/index', OrderIndex::class)->name('index');
        Route::get('/detail/{orderCode}', OrderDetail::class)->name('detail');
    });
    Route::get('/user-managements/index', UserManagementIndex::class)->name('user_management.index');
});
