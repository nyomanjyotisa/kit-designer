<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Productset_controller;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\FabricController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\PatternController;
use App\Http\Controllers\PatternStyleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\SavedDesignController;

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
Route::get('/', function () { return view('home'); });


Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () {	 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// dashboard route  
	Route::get('/dashboard', function () { 
		return view('pages.dashboard'); 
	})->name('dashboard');

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


	// permission examples
    Route::get('/permission-example', function () {
    	return view('permission-example'); 
    });
    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	Route::get('/table-datatable-edit', function () { 
		return view('pages.datatable-editable'); 
	});

    // Themekit demo pages
	Route::get('/calendar', function () { return view('pages.calendar'); });
	Route::get('/charts-amcharts', function () { return view('pages.charts-amcharts'); });
	Route::get('/charts-chartist', function () { return view('pages.charts-chartist'); });
	Route::get('/charts-flot', function () { return view('pages.charts-flot'); });
	Route::get('/charts-knob', function () { return view('pages.charts-knob'); });
	Route::get('/forgot-password', function () { return view('pages.forgot-password'); });
	Route::get('/form-addon', function () { return view('pages.form-addon'); });
	Route::get('/form-advance', function () { return view('pages.form-advance'); });
	Route::get('/form-components', function () { return view('pages.form-components'); });
	Route::get('/form-picker', function () { return view('pages.form-picker'); });
	Route::get('/invoice', function () { return view('pages.invoice'); });
	Route::get('/layout-edit-item', function () { return view('pages.layout-edit-item'); });
	Route::get('/layouts', function () { return view('pages.layouts'); });

	Route::get('/navbar', function () { return view('pages.navbar'); });
	Route::get('/profile', [UserController::class,'profileIndex']);
	Route::post('/profile/update', [UserController::class,'profileUpdate']);
	Route::get('/project', function () { return view('pages.project'); });
	Route::get('/view', function () { return view('pages.view'); });

	Route::get('/table-bootstrap', function () { return view('pages.table-bootstrap'); });
	Route::get('/table-datatable', function () { return view('pages.table-datatable'); });
	Route::get('/taskboard', function () { return view('pages.taskboard'); });
	Route::get('/widget-chart', function () { return view('pages.widget-chart'); });
	Route::get('/widget-data', function () { return view('pages.widget-data'); });
	Route::get('/widget-statistic', function () { return view('pages.widget-statistic'); });
	Route::get('/widgets', function () { return view('pages.widgets'); });

	// themekit ui pages
	Route::get('/alerts', function () { return view('pages.ui.alerts'); });
	Route::get('/badges', function () { return view('pages.ui.badges'); });
	Route::get('/buttons', function () { return view('pages.ui.buttons'); });
	Route::get('/cards', function () { return view('pages.ui.cards'); });
	Route::get('/carousel', function () { return view('pages.ui.carousel'); });
	Route::get('/icons', function () { return view('pages.ui.icons'); });
	Route::get('/modals', function () { return view('pages.ui.modals'); });
	Route::get('/navigation', function () { return view('pages.ui.navigation'); });
	Route::get('/notifications', function () { return view('pages.ui.notifications'); });
	Route::get('/range-slider', function () { return view('pages.ui.range-slider'); });
	Route::get('/rating', function () { return view('pages.ui.rating'); });
	Route::get('/session-timeout', function () { return view('pages.ui.session-timeout'); });
	Route::get('/pricing', function () { return view('pages.pricing'); });


	// new inventory routes
	Route::get('/inventory', function () { return view('inventory.dashboard'); });
	Route::get('/pos', function () { return view('inventory.pos'); });
	// Route::get('/products', function () { return view('inventory.product.list'); });
	// Route::get('/products/create', function () { return view('inventory.product.create'); });  

	
	// Product set routes
	Route::get('/products/set', [Productset_controller::class,'getProductSet'])->name('product_set');
	Route::get('/products/set/loadDatatable', [Productset_controller::class,'loadDatatable'])->name('loadDatatable');
	Route::get('/products/set/edit/{id}', [Productset_controller::class,'edit'])->name('edit');
	Route::get('/products/set/delete/{id}', [Productset_controller::class,'delete'])->name('delete-productset');
	Route::get('products/productset/create/{parentId?}', [Productset_controller::class,'create'])->name('create-product_set');
	Route::post('products/productset/create', [Productset_controller::class,'store'])->name('store-product_set');
	Route::post('products/productset/update', [Productset_controller::class,'update'])->name('update-product_set');

	// Sizes routes
	Route::get('/sizes', [SizeController::class,'index'])->name('size-list'); 
	Route::get('/sizes/create', [SizeController::class,'create'])->name('create-size'); 
	Route::get('/sizes/loadDatatable_mens', [SizeController::class,'loadDatatable_mens'])->name('loadDatatable_mens'); 
	Route::get('/sizes/loadDatatable_womens', [SizeController::class,'loadDatatable_womens'])->name('loadDatatable_womens'); 
	Route::get('/sizes/loadDatatable_kids', [SizeController::class,'loadDatatable_kids'])->name('loadDatatable_kids'); 
	Route::get('/sizes/loadDatatable_unisex', [SizeController::class,'loadDatatable_unisex'])->name('loadDatatable_unisex'); 
	Route::post('/sizes/create', [SizeController::class,'store'])->name('store-size'); 
	Route::get('/sizes/edit/{id}', [SizeController::class,'edit'])->name('edit');
	Route::get('/sizes/delete/{id}', [SizeController::class,'delete'])->name('delete-size');
	Route::post('/sizes/update', [SizeController::class,'update'])->name('update-size'); 

	// Fabric routes
	Route::get('/fabrics', [FabricController::class,'index'])->name('fabric-list'); 
	Route::get('/fabrics/create', [FabricController::class,'create'])->name('create-fabric'); 
	Route::post('/fabrics/create', [FabricController::class,'store'])->name('store-fabric');
	Route::get('/fabrics/loadDatatable', [FabricController::class,'loadDatatable'])->name('loadDatatable'); 
	Route::get('/fabrics/edit/{id}', [FabricController::class,'edit'])->name('edit');
	Route::post('/fabrics/update', [FabricController::class,'update'])->name('update-fabric'); 
	Route::post('/fabrics/savecolour', [FabricController::class,'savecolour'])->name('save-fabric-colour'); 
	Route::post('/fabrics/deletecolour', [FabricController::class,'deletecolour'])->name('delete-fabric-colour'); 


	// Design Route
	Route::get('/designs', [DesignController::class,'index'])->name('design-list'); 
	Route::get('/designs/create', [DesignController::class,'create'])->name('create-designproduct'); 
	Route::get('/designs/loadDatatable', [DesignController::class,'loadDatatable'])->name('loadDatatable'); 
	Route::post('/designs/create', [DesignController::class,'store'])->name('store-designproduct');
	Route::get('/designs/edit/{id}', [DesignController::class,'edit'])->name('edit');
	Route::get('/designs/show/{id}', [DesignController::class,'show'])->name('show-designproduct');
	Route::get('/designs/delete/{id}', [DesignController::class,'delete'])->name('design-delete');
	Route::post('/designs/update', [DesignController::class,'update'])->name('update-designproduct'); 

	//Design pattern Routes 
	Route::get('/designs/pattern/create/{id}', [PatternController::class,'create'])->name('create-pattern'); 
	Route::post('/designs/pattern/create', [PatternController::class,'store'])->name('store-pattern'); 
	Route::get('/designs/pattern/edit/{id}', [PatternController::class,'edit'])->name('edit-pattern');	
	Route::post('/designs/pattern/update', [PatternController::class,'update'])->name('update-pattern');	
	 


	//style Routes
	Route::get('/designs/{designid}/{patternid}/{add?}/{gender?}', [PatternStyleController::class,'create'])->name('create-patternStyle'); 
	Route::post('/designs/style/create', [PatternStyleController::class,'store'])->name('store-patternStyle'); 
	Route::post('/designs/style/update', [PatternStyleController::class,'update'])->name('update-patternStyle'); 
	Route::get('/designs/style/edit/{designid}/{patternid}/{styleid}/{gender?}', [PatternStyleController::class,'edit'])->name('edit-patternStyle'); 

	// Add Products routes
	Route::get('/products', [ProductController::class,'getProductList'])->name('list'); 
	Route::get('/products/create', [ProductController::class,'create'])->name('create-product');
	Route::post('/products/create', [ProductController::class,'store'])->name('store-product');
	
	// Categories Routes
	Route::get('/categories', [CategoryController::class,'index'])->name('category-list');
	Route::get('/categories/loadDatatable', [CategoryController::class,'loadDatatable'])->name('loadDatatable'); 
	Route::post('/categories/create', [CategoryController::class,'store'])->name('store-category');
	Route::get('/categories/edit/{id}', [CategoryController::class,'edit'])->name('edit');
	Route::post('/categories/update', [CategoryController::class,'update'])->name('update-category'); 
	Route::get('/categories/delete/{id}', [CategoryController::class,'delete'])->name('delete-category');

	// Tags Routes 
	Route::get('/tags', [TagsController::class,'index'])->name('tag-list');
	Route::post('/tags/create', [TagsController::class,'store'])->name('store-tag');
	Route::get('/tags/loadDatatable', [TagsController::class,'loadDatatable'])->name('loadDatatable'); 
	Route::post('/tags/update', [TagsController::class,'update'])->name('update-tag'); 
	Route::get('/tags/delete/{id}', [TagsController::class,'delete'])->name('delete-tag');


	// Orders routes

	Route::get('/orders', [OrderController::class,'index'])->name('order-list'); 
	Route::get('/orders/create', [OrderController::class,'create'])->name('create-order');
	Route::post('/orders/create', [OrderController::class,'store'])->name('store-order');
	Route::get('/orders/edit/{id}', [OrderController::class,'edit'])->name('edit');
	Route::get('/orders/getSize/{id}', [OrderController::class,'getSize'])->name('getSize');
	Route::post('/orders/update', [OrderController::class,'update'])->name('update-order');
	Route::get('/orders/loadDatatable', [OrderController::class,'loadDatatable'])->name('loadDatatable'); 

	// Organization routes 
	Route::post('/organization/create', [OrganizationController::class,'store'])->name('store-organization');
	Route::get('organization/getOrganization', [OrganizationController::class,'getOrganization'])->name('list-organization');
	

	//Sales routes 
	Route::get('/sales', [SalesController::class,'index'])->name('sales-list'); 
	Route::get('/sales/create', [SalesController::class,'create'])->name('create-sales');
	Route::post('/sales/create', [SalesController::class,'store'])->name('store-sales');
	Route::get('/sales/getSize/{id}', [SalesController::class,'getSize'])->name('getSize');
	Route::get('/sales/loadDatatable', [SalesController::class,'loadDatatable'])->name('loadDatatable'); 
	// customer routes 
	Route::post('customers/create', [CustomersController::class,'store'])->name('store-customer');

	// layout pages 
	// Route::get('/sales', function () { return view('inventory.sale.list'); });
	// Route::get('/sales/create', function () { return view('inventory.sale.create'); }); 
	Route::get('/purchases', function () { return view('inventory.purchase.list'); });
	Route::get('/purchases/create', function () { return view('inventory.purchase.create'); }); 
	// Route::get('/customers', function () { return view('inventory.people.customers'); }); 
	Route::get('/suppliers', function () { return view('inventory.people.suppliers'); }); 
	
	// Quote Requests routes
	
	Route::get('/quote-requests', [QuoteRequestController::class,'index'])->name('quote-requests'); 
	Route::get('/quote-requests/loadDatatable', [QuoteRequestController::class,'loadDatatable'])->name('quote-requests-load-data-table'); 

	// Saved Design routes
	Route::get('/saved-designs', [SavedDesignController::class,'index'])->name('saved-designs'); 
	Route::get('/saved-designs/loadDatatable', [SavedDesignController::class,'loadDatatable'])->name('saved-designs-load-data-table');
});


Route::get('/register', function () { return view('pages.register'); });
Route::get('/login-1', function () { return view('pages.login'); });
