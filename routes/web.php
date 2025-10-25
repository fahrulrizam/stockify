<?php

use Illuminate\Support\Facades\Route;

// =======================================================
// IMPORT CONTROLLERS
// =======================================================
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;


// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

// --- MANAJER CONTROLLERS ---
use App\Http\Controllers\Manajer\DashboardController as ManajerDashboardController;
use App\Http\Controllers\Manajer\ProductController as ManajerProductController;
use App\Http\Controllers\Manajer\BarangMenipisController;
use App\Http\Controllers\Manajer\StockInController;
use App\Http\Controllers\Manajer\StockOutController;
use App\Http\Controllers\Manajer\StockController as ManajerStockController;
use App\Http\Controllers\Manajer\ReportController as ManajerReportController;
use App\Http\Controllers\Manajer\TransactionController as ManajerTransactionController;
use App\Http\Controllers\Manajer\SupplierController as ManajerSupplierController;

// --- STAFF CONTROLLERS ---
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\TransactionController as StaffTransactionController;
use App\Http\Controllers\Staff\StockOpnameController;


// =======================================================
// ROOT & LOGIN
// =======================================================
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =======================================================
// ADMIN AREA
// =======================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,manager'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resources([
        'products'   => ProductController::class,
        'categories' => CategoryController::class,
        'suppliers'  => SupplierController::class,
        'stocks'     => StockController::class,
        'users'      => AdminUserController::class,
    ]);

    // Transaksi
    Route::resource('transactions', AdminTransactionController::class)->except(['show']);
    Route::get('/stocks/{id}/edit', [StockController::class, 'edit'])->name('stocks.edit');

    // 📊 Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');

    // ⚙️ Pengaturan
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings/save', [App\Http\Controllers\Admin\SettingController::class, 'save'])->name('admin.settings.save');
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
      // Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/save', [SettingController::class, 'save'])->name('settings.save');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// =======================================================
// MANAJER AREA
// =======================================================
Route::prefix('manajer')->name('manajer.')->middleware(['auth', 'role:manajer'])->group(function () {
    Route::get('/dashboard', [ManajerDashboardController::class, 'index'])->name('dashboard');

    // Barang Masuk
    Route::get('/barang-masuk', [ManajerTransactionController::class, 'incoming'])->name('barangmasuk');
    Route::post('/barang-masuk', [ManajerTransactionController::class, 'storeIncoming'])->name('barangmasuk.store');
    Route::get('/barang-masuk/export', [ManajerTransactionController::class, 'exportIncoming'])->name('barangmasuk.export');

    // Barang Keluar
    Route::get('/barang-keluar', [ManajerTransactionController::class, 'outgoing'])->name('barangkeluar');
    Route::post('/barang-keluar', [ManajerTransactionController::class, 'storeOutgoing'])->name('barangkeluar.store');
    Route::get('/barang-keluar/export', [ManajerTransactionController::class, 'exportOutgoing'])->name('barangkeluar.export');

    // Barang Menipis
    Route::get('/barang-menipis', [BarangMenipisController::class, 'index'])->name('barangmenipis');

    // Supplier
    Route::get('/supplier', [ManajerSupplierController::class, 'index'])->name('supplier');
    Route::resource('products', ManajerProductController::class)->names('manajer.products');

    // Stok
    Route::resource('stocks', ManajerStockController::class);
    Route::get('/stocks/export/pdf', [ManajerStockController::class, 'exportPdf'])->name('stocks.exportPdf');

    // Laporan
    Route::get('/laporan', [ManajerReportController::class, 'index'])->name('laporan');
    Route::get('/laporan/pdf', [ManajerReportController::class, 'exportPdf'])->name('laporan.pdf');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::resource('stockin', StockInController::class)->names('stockin');

    // ✅ Barang Keluar
    Route::resource('stockout', StockOutController::class)->names('stockout');
});

// =======================================================
// STAFF AREA
// =======================================================
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    // Barang Masuk
    Route::get('/barang-masuk', [StaffTransactionController::class, 'indexIncoming'])->name('barangmasuk');
    Route::post('/barang-masuk/{id}/konfirmasi', [StaffTransactionController::class, 'confirmIncoming'])->name('barangmasuk.confirm');

    // Barang Keluar
    Route::get('/barang-keluar', [StaffTransactionController::class, 'indexOutgoing'])->name('barangkeluar');
    Route::post('/barang-keluar/{id}/konfirmasi', [StaffTransactionController::class, 'confirmOutgoing'])->name('barangkeluar.confirm');

    // Stock Opname
    Route::get('/stock-opname', [StockOpnameController::class, 'index'])->name('stockopname.index');
    Route::get('/stockopname', [\App\Http\Controllers\Staff\StockOpnameController::class, 'index'])
        ->name('stockopname');
    Route::post('/stock-opname', [StockOpnameController::class, 'store'])->name('stockopname.store');
});

// =======================================================
// UMUM
// =======================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// =======================================================
// LAPORAN & PENGATURAN (GLOBAL, jika ingin diakses umum)
// =======================================================

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
// ROUTE PRODUK, KATEGORI, SUPPLIER, TRANSAKSI
Route::resource('products', ManajerProductController::class)->names('manajer.products');
Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('transactions', TransactionController::class);
Route::match(['put', 'post'], '/settings', [SettingController::class, 'update'])->name('settings.update');
Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
Route::put('/settings/update', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');


