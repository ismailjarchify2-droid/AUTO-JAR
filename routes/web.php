<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PartRequestController as AdminPartRequestController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VehicleBrandController as AdminVehicleBrandController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ApiVehicleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartRequestController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue');
Route::get('/produit/{produit:slug}', [ProductController::class, 'show'])->name('produits.show');

Route::get('/marques', [BrandController::class, 'index'])->name('marques.index');
Route::get('/marques/{marque:slug}', [BrandController::class, 'show'])->name('marques.show');
Route::get('/modeles/{marque:slug}', [VehicleController::class, 'models'])->name('modeles.show');
Route::get('/modeles/{marque:slug}/{modele:slug}', [VehicleController::class, 'modelProducts'])
    ->withoutScopedBindings()
    ->name('modeles.produits');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{categorie:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/demande-de-piece', [PartRequestController::class, 'create'])->name('demande-piece.create');
Route::post('/demande-de-piece', [PartRequestController::class, 'store'])->name('demande-piece.store');

Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/connexion', [LoginController::class, 'show'])->name('login');
Route::post('/connexion', [LoginController::class, 'store'])->name('login.store');
Route::post('/deconnexion', [LoginController::class, 'destroy'])->name('logout');

Route::get('/panier', [CartController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter', [CartController::class, 'add'])->name('panier.ajouter');
Route::patch('/panier/{product}', [CartController::class, 'update'])->name('panier.update');
Route::delete('/panier/{product}', [CartController::class, 'destroy'])->name('panier.destroy');
Route::delete('/panier', [CartController::class, 'clear'])->name('panier.clear');

Route::get('/commande', [OrderController::class, 'checkout'])->name('commande.index');
Route::post('/commande', [OrderController::class, 'store'])->name('commande.store');
Route::get('/commande/{order}', [OrderController::class, 'show'])->name('commande.show');

Route::prefix('api/vehicules')->name('api.vehicles.')->group(function () {
    Route::get('/marques', [ApiVehicleController::class, 'brands'])->name('brands');
    Route::get('/modeles', [ApiVehicleController::class, 'models'])->name('models');
    Route::get('/annees', [ApiVehicleController::class, 'years'])->name('years');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('brands', AdminBrandController::class)->except(['show']);
    Route::resource('vehicle-brands', AdminVehicleBrandController::class)->except(['show']);
    Route::post('vehicle-brands/{vehicleBrand}/models', [AdminVehicleBrandController::class, 'storeModel'])->name('vehicle-brands.models.store');

    Route::get('part-requests', [AdminPartRequestController::class, 'index'])->name('part-requests.index');
    Route::get('part-requests/{partRequest}', [AdminPartRequestController::class, 'show'])->name('part-requests.show');
    Route::put('part-requests/{partRequest}', [AdminPartRequestController::class, 'update'])->name('part-requests.update');
    Route::delete('part-requests/{partRequest}', [AdminPartRequestController::class, 'destroy'])->name('part-requests.destroy');

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

    Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

    Route::resource('users', AdminUserController::class)->except(['show']);

    Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});
