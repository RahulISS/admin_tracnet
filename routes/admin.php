<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\PortalsController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\SensorsController;
use App\Http\Controllers\ProductModelsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DeviceController;


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    /** Admin Login Routes */
    Route::get('/login', [AdminAuthController::class, 'login'])->name('adminLogin')->middleware('loginAuth');
    Route::post('/login', [AdminAuthController::class, 'handleLogin'])->name('adminLoginPost');

    Route::group(['middleware' => 'adminauth'], function () {

        Route::get('logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');

        Route::get('/dashboard', [AdminController::class, 'admin_dashboard'])->name('adminDashboard');

        //Company
        Route::get('/company', [CompaniesController::class, 'company'])->name('company');
        Route::get('/company-list', [CompaniesController::class, 'getCompanyList'])->name('companylist');
        Route::get('/company/add', [CompaniesController::class, 'add_company'])->name('addcompany');
        Route::post('/company/add', [CompaniesController::class, 'postadd_company'])->name('create.company');
        Route::get('/company/edit/{id}', [CompaniesController::class, 'edit_company'])->name('editcompany');
        Route::post('/company/update/{id}', [CompaniesController::class, 'update_company'])->name('update.company');
        Route::get('/company/delete/{id}', [CompaniesController::class, 'delete_company'])->name('delete.company');
        Route::get('/company-view/{id}', [CompaniesController::class, 'view'])->name('company.view');

        //project
        Route::get('/project-list', [ProjectsController::class, 'project_list'])->name('projectlist');
        Route::get('/project/add', [ProjectsController::class, 'add_project'])->name('addproject');
        Route::post('/project/add', [ProjectsController::class, 'postadd_project'])->name('create.project');
        Route::get('/project/edit/{id}', [ProjectsController::class, 'edit_project'])->name('editproject');
        Route::post('/project/update/{id}', [ProjectsController::class, 'update_project'])->name('update.project');
        Route::get('/project/delete/{id}', [ProjectsController::class, 'delete_project'])->name('delete.project');
        Route::get('/project/view/{id}', [ProjectsController::class, 'view'])->name('project.view');


        //customer
        Route::get('/user-ajax-list', [CustomersController::class, 'userAjaxList'])->name('userajaxlist');
        Route::get('/user-list', [CustomersController::class, 'customer_list'])->name('customerlist');
        Route::get('/user/add', [CustomersController::class, 'add_customer'])->name('addcustomer');
        Route::post('/user/add', [CustomersController::class, 'postadd_customer'])->name('create.customer');
        Route::get('/user/edit/{id}', [CustomersController::class, 'edit_customer'])->name('editcustomer');
        Route::post('/user/update/{id}', [CustomersController::class, 'update_customer'])->name('update.customer');
        Route::get('/user/delete/{id}', [CustomersController::class, 'delete_customer'])->name('delete.customer');
        Route::get('/user-view/{id}', [CustomersController::class, 'view'])->name('customer.view');
        // Route::post('/ajax/get-portal', [CustomersController::class, 'get_portal'])->name('getPortal');

        // portal
        Route::get('/portal-ajax-data', [PortalsController::class, 'portalAjaxData'])->name('portalajaxdata');
        Route::get('/portal-list', [PortalsController::class, 'portal_list'])->name('portallist');
        Route::get('/portal/add', [PortalsController::class, 'add_portal'])->name('addportal');
        Route::post('/portal/add', [PortalsController::class, 'postadd_portal'])->name('create.portal');
        Route::get('/portal/edit/{id}', [PortalsController::class, 'edit_portal'])->name('editportal');
        Route::post('/portal/update/{id}', [PortalsController::class, 'update_portal'])->name('update.portal');
        Route::get('/portal/delete/{id}', [PortalsController::class, 'delete_portal'])->name('delete.portal');

        // module
        Route::get('/module-ajax-data', [ModulesController::class, 'moduleAjaxData'])->name('moduleajaxdata');
        Route::get('/module-list', [ModulesController::class, 'module_list'])->name('modulelist');
        Route::get('/module/add', [ModulesController::class, 'add_module'])->name('addmodule');
        Route::post('/module/add', [ModulesController::class, 'postadd_module'])->name('create.module');
        Route::get('/module/edit/{id}', [ModulesController::class, 'edit_module'])->name('editmodule');
        Route::post('/module/update/{id}', [ModulesController::class, 'update_module'])->name('update.module');
        Route::get('/module/delete/{id}', [ModulesController::class, 'delete_module'])->name('delete.module');

        // sub module
        Route::get('/sub-module/add', [ModulesController::class, 'add_submodule'])->name('addsubmodule');
        Route::post('/sub-module/add', [ModulesController::class, 'postadd_submodule'])->name('create.submodule');

         // role
         Route::get('/role-list', [RolesController::class, 'role_list'])->name('rolelist');
         Route::get('/role/add', [RolesController::class, 'add_role'])->name('addrole');
         Route::post('/role/add', [RolesController::class, 'postadd_role'])->name('create.role');
         Route::get('/role/edit/{id}', [RolesController::class, 'edit_role'])->name('editrole');
         Route::post('role/update/{id}', [RolesController::class, 'update_role'])->name('update.role');
         Route::get('/role/delete/{id}', [RolesController::class, 'delete_role'])->name('delete.role');

         // permission
         Route::get('/permission-list', [PermissionsController::class, 'permission_list'])->name('permissionlist');
         Route::get('/permission/add', [PermissionsController::class, 'add_permission'])->name('addpermission');
         Route::post('/permission/add', [PermissionsController::class, 'postadd_permission'])->name('create.permission');
         Route::get('/permission/edit/{id}', [PermissionsController::class, 'edit_permission'])->name('editpermission');
         Route::post('permission/update/{id}', [PermissionsController::class, 'update_permission'])->name('update.permission');
         Route::get('/permission/delete/{id}', [PermissionsController::class, 'delete_permission'])->name('delete.permission');

        // Unit
        Route::get('/unit-ajax-data', [UnitsController::class, 'unitAjaxData'])->name('unitajaxdata');
        Route::get('/unit-list', [UnitsController::class, 'unit_list'])->name('unitlist');
        Route::get('/unit/add', [UnitsController::class, 'add_unit'])->name('addunit');
        Route::post('/unit/add', [UnitsController::class, 'postadd_unit'])->name('create.unit');
        Route::get('/unit/edit/{id}', [UnitsController::class, 'edit_unit'])->name('editunit');
        Route::post('/unit/update/{id}', [UnitsController::class, 'update_unit'])->name('update.unit');
        Route::get('/unit/delete/{id}', [UnitsController::class, 'delete_unit'])->name('delete.unit');

        //Sensors
        Route::get('/sensor-ajax-data', [SensorsController::class, 'sensorAjaxData'])->name('sensorajaxdata');
        Route::get('/sensor-list', [SensorsController::class, 'sensor_list'])->name('sensorlist');
        Route::get('/sensor/add', [SensorsController::class, 'add_sensor'])->name('addsensor');
        Route::post('/sensor/add', [SensorsController::class, 'postadd_sensor'])->name('create.sensor');
        Route::get('/sensor/edit/{id}', [SensorsController::class, 'edit_sensor'])->name('editsensor');
        Route::post('/sensor/update/{id}', [SensorsController::class, 'update_sensor'])->name('update.sensor');
        Route::get('/sensor/delete/{id}', [SensorsController::class, 'delete_sensor'])->name('delete.sensor');

        //ProductModels
        Route::get('/productModel-list', [ProductModelsController::class, 'product_model_list'])->name('productModellist');
        Route::get('/productModel/add', [ProductModelsController::class, 'add_product_model'])->name('addproductModel');
        Route::post('/productModel/add', [ProductModelsController::class, 'postadd_product_model'])->name('create.productModel');
        Route::get('/productModel/edit/{id}', [ProductModelsController::class, 'edit_product_model'])->name('editproductModel');
        Route::post('/productModel/update/{id}', [ProductModelsController::class, 'update_product_model'])->name('update.productModel');
        Route::get('/productModel/delete/{id}', [ProductModelsController::class, 'delete_product_model'])->name('delete.productModel');

        //Product
        Route::get('/product-list', [ProductsController::class, 'product_list'])->name('productlist');
        Route::get('/product/add', [ProductsController::class, 'add_product'])->name('addproduct');
        Route::post('/product/add', [ProductsController::class, 'postadd_product'])->name('create.product');
        Route::get('/product/edit/{id}', [ProductsController::class, 'edit_product'])->name('editproduct');
        Route::post('/product/update/{id}', [ProductsController::class, 'update_product'])->name('update.product');
        Route::get('/product/delete/{id}', [ProductsController::class, 'delete_product'])->name('delete.product');

        //DMS
        Route::get('/dms-view', [DeviceController::class, 'device_list'])->name('dms.view');
    });

    //under the customer
    Route::post('/ajax/get-portal', [CustomersController::class, 'get_portal'])->name('getPortal');

    Route::post('/ajax/get-Projectportal', [PermissionsController::class, 'get_projectportal'])->name('getProjectportal');

    Route::get('/dms/companies', [AdminController::class, 'dms_companies'])->name('dms.companies');
    Route::get('/ajax/get-project', [CustomersController::class, 'get_project'])->name('getProject');
    Route::post('/ajax/get-role', [CustomersController::class, 'get_role'])->name('getRole');
    Route::post('/ajax/get-role-permission', [PermissionsController::class, 'get_roles_permission'])->name('getRoleper');
    Route::post('/ajax/get-Userportal', [PermissionsController::class, 'get_userportal'])->name('getUserportal');

    //under the company
    Route::get('/ajax/getCompanyProjects', [CompaniesController::class , 'get_company_project'])->name('company.projects'); 
});