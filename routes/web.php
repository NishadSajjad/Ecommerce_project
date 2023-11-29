<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'Index')->name('Home');
});

Route::controller(ClientController::class)->group(function () {
    Route::get('/category/{id}/{slug}', 'CategoryPage')->name('category');
    Route::get('/single-Product/{id}/{slug}', 'SingleProduct')->name('singleproduct');
    Route::get('/add-to-cart', 'AddToCart')->name('addtocart');
    Route::get('/checkout', 'CheckOut')->name('checkout');
    Route::get('/user-profile', 'UserProfile')->name('userprofile');
    Route::get('/new-release', 'NewRelease')->name('newrelease');
    Route::get('/todays-deal', 'TodaysDeal')->name('todaysdeal');
    Route::get('/costomer-service', 'CostomerService')->name('costomerservice');
});



// deshbord start

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])
->group(function () {
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/admin/dashboard', 'index')->name('admindashboard');
    });
    
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/admin/all-category', 'index')->name('allcategory');
        Route::get('/admin/add-category', 'addCategory')->name('addcategory');
        Route::post('/admin/store-category', 'storecategory')->name('storecategory');
        Route::get('/admin/edit-category/{id}', 'EditCategory')->name('editcategory');
        Route::post('/admin/update-category', 'UpdateCategory')->name('updatecategory');
        Route::get('/admin/delete-category/{id}', 'DeleteCategory')->name('deletecategory');




    });

    Route::controller(SubCategoryController::class)->group(function(){
        Route::get('/admin/all-Subcategory', 'index')->name('allSubcategory');
        Route::get('/admin/add-Subcategory', 'addSubCategory')->name('addSubcategory');
        Route::post('/admin/store-Subcategory', 'StoreSubCategory')->name('storesubcategory');
        Route::get('/admin/edit-Subcategory/{id}', 'EditSubCat')->name('editsubcat');
        Route::get('/admin/delete-Subcategory/{id}', 'DeleteSubCat')->name('deletesubcat');
        Route::post('/admin/update-Subcategory', 'updateSubCat')->name('updatesubcat');
    });
   
    Route::controller(ProductController::class)->group(function(){
        Route::get('/admin/all-Product', 'index')->name('allProduct');
        Route::get('/admin/add-Product', 'addProduct')->name('addProduct');
        Route::post('/admin/store-Product', 'StoreProduct')->name('storeproduct');
        Route::get('/admin/edit-Product-img/{id}', 'EditProductImg')->name('editproductimg');
        Route::post('/admin/update-Product-img', 'UpdateProductImg')->name('updateproductimg');
        Route::get('/admin/edit-Product/{id}', 'EditProduct')->name('editproduct');
        Route::post('/admin/edit-Product/{product}', 'UpdateProduct')->name('updateproduct');
        Route::get('/admin/delete-Product/{id}', 'DeleteProduct')->name('deleteproduct');
        

    });
   
    Route::controller(OrderController::class)->group(function(){
        Route::get('/admin/pending-Order', 'index')->name('pendingOrder');
        
    });
   

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
