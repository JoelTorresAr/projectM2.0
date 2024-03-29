<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
DB::listen(function($e){
    dump($e->sql);
});*/

//Cliente
Route::group(['prefix' => 'user', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginClientController@login');
});

Route::group(['prefix' => 'user', 'namespace' => 'Auth'], function () {
    Route::post('register', 'LoginClientController@register');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Administrador
Route::group(['prefix' => 'admin', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginAdminController@login');
});

//SubsidiaryController
Route::group(['prefix' => 'subsidiaries', 'namespace' => 'Api'], function () {
    Route::get('/', 'SubsidiaryController@index');
    Route::get('list/onlyname', 'SubsidiaryController@listOnlyName');
});

//IgvController
Route::group(['prefix' => 'igvs', 'namespace' => 'Api'], function () {
    Route::get('current', 'IgvController@current');
});

//CategoryController
Route::group(['prefix' => 'categories', 'namespace' => 'Api'], function () {
    Route::get('list/onlyname', 'CategoryController@listOnlyName');
    Route::get('/', 'CategoryController@index');
    Route::post('store', 'CategoryController@store');
    Route::put('update/{category}', 'CategoryController@update');
    Route::delete('destroy/{category}', 'CategoryController@destroy');
});

//OfferController
Route::group(['prefix' => 'offers', 'namespace' => 'Api'], function () {
    Route::get('/', 'OfferController@index');
    Route::get('list/onlyname', 'OfferController@listOnlyName');
    Route::post('store', 'OfferController@store');
    Route::put('update/{offer}', 'OfferController@update');
    Route::delete('destroy/{offer}', 'OfferController@destroy');
});

//ProviderController
Route::group(['prefix' => 'providers', 'namespace' => 'Api'], function () {
    Route::get('list/onlyname', 'ProviderController@listOnlyName');
    Route::get('/', 'ProviderController@index');
});

//ArticleController
Route::group(['prefix' => 'articles', 'namespace' => 'Api'], function () {
    Route::get('/', 'ArticleController@index');
    Route::get('searchbyid/{id}', 'ArticleController@searchbyid');
    Route::get('searchbycategoryid/{id}', 'ArticleController@searchbycategoryid');
    Route::get('searchbyname/{name}', 'ArticleController@searchbyname');
    Route::get('listby/{subsidiary}', 'ArticleController@indexbysubsidiary');
    Route::post('store', 'ArticleController@store');
    Route::post('update/{article}', 'ArticleController@update');
    Route::delete('destroy/{article}', 'ArticleController@destroy');
});

//SaleController
Route::group(['prefix' => 'sales', 'namespace' => 'Api'], function () {
    Route::get('/', 'SaleController@index');
    Route::post('store', 'SaleController@store');
    Route::post('update/{article}', 'SaleController@update');
    Route::delete('destroy/{article}', 'SaleController@destroy');
});

//ShelfController
Route::group(['prefix' => 'shelves', 'namespace' => 'Api'], function () {
    Route::get('/', 'ShelfController@index');
    Route::get('list/onlynamebysubsidiary/{subsidiary}', 'ShelfController@listOnlyNamebySubsidiary');
});

Route::group(['middleware' => ['auth:admin']], function () {
    //StaffController
    Route::group(['prefix' => 'staff', 'namespace' => 'Api'], function () {
        Route::get('/', 'StaffController@index');
        Route::get('list/noncredential', 'StaffController@nonCredentialStaff');
        Route::post('store', 'StaffController@store')->name('staff.store');
        Route::put('update/{staff}', 'StaffController@update');
        Route::delete('destroy/{staff}', 'StaffController@destroy');
    });

    //SubsidiaryController
    Route::group(['prefix' => 'subsidiaries', 'namespace' => 'Api'], function () {
        Route::post('store', 'SubsidiaryController@store');
        Route::put('update/{subsidiary}', 'SubsidiaryController@update');
        Route::delete('destroy/{subsidiary}', 'SubsidiaryController@destroy');
    });

    //WorkstationController
    Route::group(['prefix' => 'workstations', 'namespace' => 'Api'], function () {
        Route::get('/', 'WorkstationController@index');
        Route::post('store', 'WorkstationController@store');
        Route::put('update/{workstation}', 'WorkstationController@update');
        Route::delete('destroy/{workstation}', 'WorkstationController@destroy');
    });

    //WorkpositionController
    Route::group(['prefix' => 'workpositions', 'namespace' => 'Api'], function () {
        Route::get('/', 'WorkpositionController@index');
        Route::get('showbyworkstation/{workstation}', 'WorkpositionController@showbyworkstation');
        Route::post('store', 'WorkpositionController@store');
        Route::put('update/{workstation}', 'WorkpositionController@update');
        Route::delete('destroy/{workstation}', 'WorkpositionController@destroy');
    });

    //DistrictController
    Route::group(['prefix' => 'districts', 'namespace' => 'Api'], function () {
        Route::get('/', 'DistrictController@index');
        Route::get('showbycity/{city}', 'DistrictController@showbycity');
        Route::post('store', 'DistrictController@store');
        Route::put('update/{district}', 'DistrictController@update');
        Route::delete('destroy/{district}', 'DistrictController@destroy');
    });

    //CityController
    Route::group(['prefix' => 'cities', 'namespace' => 'Api'], function () {
        Route::get('/', 'CityController@index');
        Route::get('showbydistrict/{district}', 'CityController@showbydistrict');
        Route::post('store', 'CityController@store');
        Route::put('update/{city}', 'CityController@update');
        Route::delete('destroy/{city}', 'CityController@destroy');
    });

    //AdminController
    Route::group(['prefix' => 'admins', 'namespace' => 'Api'], function () {
        Route::get('/', 'AdminController@list');
        Route::get('dashboard/', 'AdminController@dashboard');
        Route::get('list/onlyname', 'AdminController@listOnlyName');
        Route::post('store', 'AdminController@store');
        Route::put('update/{admin}', 'AdminController@update');
        Route::put('assign/{admin}', 'AdminController@assign');
        Route::delete('destroy/{admin}', 'AdminController@destroy');
    });
    //RolesController
    Route::group(['prefix' => 'roles', 'namespace' => 'Api'], function () {
        Route::get('/', 'RoleController@index');
        Route::get('list/OnlyName', 'RoleController@listOnlyName');
        Route::post('store', 'RoleController@store');
        Route::put('update/{role}', 'RoleController@update');
        Route::delete('destroy/{role}', 'RoleController@destroy');
    });

    //PermissionController
    Route::group(['prefix' => 'permissions', 'namespace' => 'Api'], function () {
        Route::get('/', 'PermissionController@index');
        Route::get('list/OnlyName', 'PermissionController@listOnlyName');
        Route::post('store', 'PermissionController@store');
        Route::put('update/{permission}', 'PermissionController@update');
        Route::delete('destroy/{permission}', 'PermissionController@destroy');
    });

    //CategoryController
    Route::group(['prefix' => 'categories', 'namespace' => 'Api'], function () {
    });

    //OfferController
    Route::group(['prefix' => 'offers', 'namespace' => 'Api'], function () {
    });

    //ProviderController
    Route::group(['prefix' => 'providers', 'namespace' => 'Api'], function () {
        Route::post('store', 'ProviderController@store');
        Route::put('update/{provider}', 'ProviderController@update');
        Route::delete('destroy/{provider}', 'ProviderController@destroy');
    });

    //IgvController
    Route::group(['prefix' => 'igvs', 'namespace' => 'Api'], function () {
        Route::get('/', 'IgvController@index');
        Route::post('store', 'IgvController@store');
        Route::put('update/{provider}', 'IgvController@update');
        Route::delete('destroy/{provider}', 'IgvController@destroy');
    });

    //ProoftypeController
    Route::group(['prefix' => 'prooftypes', 'namespace' => 'Api'], function () {
        Route::get('/', 'ProoftypeController@index');
        Route::post('store', 'ProoftypeController@store');
        Route::put('update/{prooftype}', 'ProoftypeController@update');
        Route::delete('destroy/{prooftype}', 'ProoftypeController@destroy');
    });

    //ShelfController
    Route::group(['prefix' => 'shelves', 'namespace' => 'Api'], function () {
        Route::get('list/bydealer/{dealer}', 'ShelfController@listbyDealer');
        Route::post('store', 'ShelfController@store');
        Route::put('update/{shelf}', 'ShelfController@update');
        Route::delete('destroy/{shelf}', 'ShelfController@destroy');
    });

    //ArticleController
    Route::group(['prefix' => 'articles', 'namespace' => 'Api'], function () {
    });

    //PhotosController
    Route::group(['prefix' => 'photos', 'namespace' => 'Api'], function () {
        Route::post('store/article', 'PhotosController@storeArticle');
    });

    //DealerController
    Route::group(['prefix' => 'dealers', 'namespace' => 'Api'], function () {
        Route::get('/', 'DealerController@index');
        Route::get('list/onlyname', 'DealerController@listOnlyName');
        Route::post('store', 'DealerController@store');
        Route::put('update/{dealer}', 'DealerController@update');
        Route::delete('destroy/{dealer}', 'DealerController@destroy');
    });

    //ConcessionController
    Route::group(['prefix' => 'concessions', 'namespace' => 'Api'], function () {
        // Route::get('/','ConcessionController@index');
        Route::get('list/shelves/{subsidiary}', 'ConcessionController@listShelvesAvailablesbySubsidiary');
        //Route::get('list/onlyname','ConcessionController@listOnlyName');
        Route::post('store/{dealer}', 'ConcessionController@store');
        // Route::put('update/{dealer}','ConcessionController@update');
        Route::delete('destroy/{shelf}', 'ConcessionController@destroy');
    });
});

//Dealer routes

Route::group(['prefix' => 'dealer', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginDealerController@login');
});

Route::group(['middleware' => ['auth:dealer']], function () {

    //DealerController
    Route::group(['prefix' => 'dealer', 'namespace' => 'Auth'], function () {
        Route::get('/me', 'LoginDealerController@me');
        Route::post('/logout', 'LoginDealerController@logout');
    });
});
