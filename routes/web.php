<?php

use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\UserPaymentMethodController;
use Illuminate\Support\Facades\Route;

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

// Track Controller
Route::get('/track/postback/{veri_slot}', 'TrackController@postback');
Route::get('/track/{campaign_id}/{user_id}/{subid1?}/{subid2?}/{subid3?}/{subid4?}/{subid5?}', 'TrackController@track')->where(['campaign_id' => '[0-9]+', 'user_id' => '[0-9]+']);

// Account Routes
Route::get('/account/create/complete', 'Auth\RegisterController@getRegisterComplete');

Route::get('/emailconfirm/{id}/{email_confirm_code}', 'Auth\RegisterController@confirmEmail');

// Support Ticket
Route::prefix('/support')->name('support.')->group(function () {
    Route::get('/', [SupportTicketController::class, 'index'])->name('index');
    Route::get('/create-ticket', [SupportTicketController::class, 'create'])->name('create');
    Route::post('/', [SupportTicketController::class, 'store'])->name('store');
    Route::get('/{id}', [SupportTicketController::class, 'show'])->name('show');
    Route::put('/{ticket}/update-status', [SupportTicketController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/{ticket}/store-response', [SupportTicketController::class, 'storeResponse'])->name('storeResponse');
});

// Routes for guest users
Route::middleware('guest')->group(function () {
    // Registration routes...
    Route::get('/account/create', 'Auth\RegisterController@getRegister');
    Route::post('/account/create', 'Auth\RegisterController@postRegister');

    //Invite Controller
    Route::get('/invite/{id}', 'InviteController@getId');

    // Password Reset Routes...
    Route::get('password/reset/', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
});

Route::middleware('auth')->group(function () {
    Route::get('/login/check', 'Auth\LoginController@checkpoint');

    // Registration
    Route::get('/account/create/networks', 'Auth\RegisterController@getRegisterNetworks');
    Route::post('/account/create/networks', 'Auth\RegisterController@postRegisterNetworks');
    Route::get('/account/create/address', 'Auth\RegisterController@getRegisterAddress');
    Route::post('/account/create/address', 'Auth\RegisterController@postRegisterAddress');
    Route::get('/account/create/payment', 'Auth\RegisterController@getRegisterPayment');
    Route::post('/account/create/payment', 'Auth\RegisterController@postRegisterPayment');
    Route::get('/register/{service}/', 'Auth\RegisterController@redirectToProvider');
});

Route::middleware([])->group(function () {
    // Routes for authenticated users
    Route::middleware(['status', 'user'])->group(function () {
        // Dashboard
        Route::get('/dashboard', 'User\DashboardController@index');
        // Reports
        Route::get('/reports', 'User\ReportsController@index');
        // Report for specific id
        Route::get('/report/{id}', 'User\ReportsController@show');
        Route::get('/shoutouts', 'UserController@shoutouts');
        Route::get('/payouts', 'UserController@getPayouts');
        Route::post('/payouts', 'UserController@postPayouts');
        Route::get('/campaigns', 'CampaignController@index');
        Route::get('/campaign/{id}', 'CampaignController@show');
        Route::resource('/tools/snapmoney', 'User\Tools\SnapMoneyController');

        // Invite
        Route::get('/invite', 'InviteController@index');

        //Settings
        Route::get('/settings/', 'User\SettingsController@index');
        Route::get('/settings/password', 'User\SettingsController@password');
        Route::post('/settings/password', 'User\SettingsController@updatePassword');
        Route::post('/settings/updateInfo', 'User\SettingsController@updateInfo');
        Route::post('/settings/updateNotifications', 'User\SettingsController@updateNotifications');
        Route::post('/settings/updatePassword', 'User\SettingsController@updatePassword');
        Route::get('/taxdetails', 'UserController@getTaxDetails');
        Route::post('/taxdetails', 'UserController@postTaxDetails');

        // Upload file
        Route::get('/file/show', 'FileManagerController@show')->name('file.show');
        Route::post('/file/store', 'FileManagerController@store');
    });

    // No middlewares. Anyone can access
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/earn', 'HomeController@earn');
    Route::get('/business', 'HomeController@business');
    Route::get('/about', 'HomeController@about');
    Route::get('/rewards', 'HomeController@rewards');
    Route::get('/faqs', 'HomeController@faqs');
    Route::get('/privacy', 'HomeController@privacy');
    Route::get('/terms', 'HomeController@terms');

    // Campaign Controller
    Route::get('/campaign/image/{name}', 'Admin\CampaignController@featureImage');
});

// Only admin and owner has access
Route::prefix('admin')->group(function () {
    // Debug route
    Route::get('/info', function () {
        if (extension_loaded('gd')) {
            echo "gd is loaded";//->middleware(['admin'])
        } else {
            echo "gd is not loaded";
        }
        echo phpinfo();
    });

    // Admin
    Route::get('/', 'Admin\AdminController@index');
    
    // Route::post('/payment/method')
    // payment methods
    Route::resource('payment/methods', UserPaymentMethodController::class);
    // Route::post('payment/create','Admin\UserPaymentMethodController@create');
    Route::get('/', 'Admin\AdminController@index');


    // Publishers
    Route::prefix('publishers')->group(function () {
        Route::get('/', 'Admin\PublisherController@index');
        Route::get('/my', 'Admin\PublisherController@my');
        Route::get('/{id}', 'Admin\PublisherController@show');
        Route::get('/{id}/edit', 'Admin\PublisherController@edit');
        Route::put('/{id}', 'Admin\PublisherController@update');
        Route::delete('/{id}', 'Admin\PublisherController@destroy');
    });

    // Postback
    Route::resource('/postbacks', 'Admin\PostbackController');
    Route::get('/postbacks/{id}/delete', 'Admin\PostbackController@destroy');

    // Campaigns
    Route::prefix('campaigns')->group(function () {
        Route::get('/create', 'Admin\CampaignController@create');
        Route::get('/ogads/import/', 'Admin\CampaignController@getOgadsImport');
        Route::post('/ogads/import/', 'Admin\CampaignController@postOgadsImportSelected');
        Route::get('/categories', 'Admin\CampaignController@categories');
        Route::get('/rates', 'Admin\CampaignController@getRates');
        Route::post('/rates', 'Admin\CampaignController@postRates');
        Route::put('/rates', 'Admin\CampaignController@putRates');
        Route::get('/featured', 'Admin\CampaignController@getFeatured');
        Route::post('/featured', 'Admin\CampaignController@postFeatured');
        Route::get('/subidblock', 'Admin\CampaignController@subidblock');
        Route::get('/singleblock', 'Admin\CampaignController@singleblock');
        Route::get('/networkblock', 'Admin\CampaignController@networkblock');
        Route::get('/{network_id?}', 'Admin\CampaignController@index');
        Route::resource('/', 'Admin\CampaignController');
    });

    // Support tickets
    Route::prefix('tickets')->name('admin.tickets.')->group(function () {
        Route::get('/', [SupportTicketController::class, 'index'])->name('index');
        Route::get('/{ticket}', [SupportTicketController::class, 'show'])->name('show');
        Route::put('/{ticket}/status', [SupportTicketController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/{ticket}/response', [SupportTicketController::class, 'storeResponse'])->name('storeResponse');
    });

    // Campaign Reports
    Route::get('/reports/options/{id}/{status}', 'Admin\ReportsController@options');
    Route::resource('/reports', 'Admin\ReportsController');


    
    // Payments
    Route::get('/payments', 'Admin\PaymentController@index');
    Route::post('/payments', 'Admin\PaymentController@generate');
   
    // my payment 
    Route::get('/payment/methods', 'mypayController@index');
    Route::Post('/payment/methods/add','mypayController@store');
    //Rewards
    Route::resource('/rewards', 'Admin\RewardsController');

    //posts routes
    Route::prefix('blog/posts')->name('posts.')->group(function () {
        Route::get('/', 'Admin\BlogsController@index')->name('list');
        Route::get('/trash', 'Admin\BlogsController@trash')->name('trash');
        Route::get('/trash/recover/{id}', 'Admin\BlogsController@recover')->name('recover');
        Route::get('/create', 'Admin\BlogsController@create')->name('create');
        Route::get('/edit/{id}', 'Admin\BlogsController@edit')->name('edit');
        Route::put('/update/{product}', 'Admin\BlogsController@update')->name('update');
        Route::post('/store', 'Admin\BlogsController@store')->name('store');
        Route::get('/delete/{id}', 'Admin\BlogsController@destroy')->name('delete');
        Route::get('/get', 'Admin\BlogsController@get')->name('get');
    });

    //posts routes
    Route::prefix('blog/categories')->name('blog.categories.')->group(function () {
        Route::get('/', 'Admin\BlogcategoriesController@index')->name('list');
        Route::get('/create', 'Admin\BlogcategoriesController@create')->name('create');
        Route::get('/edit/{id}', 'Admin\BlogcategoriesController@edit')->name('edit');
        Route::get('/delete/{id}', 'Admin\BlogcategoriesController@destroy')->name('delete');
        Route::put('/update/{product}', 'Admin\BlogcategoriesController@update')->name('update');
        Route::post('/store', 'Admin\BlogcategoriesController@store')->name('store');
        Route::get('/get', 'Admin\BlogcategoriesController@get')->name('get');
    });

    Route::prefix('blog/tags')->name('blog.tags.')->group(function () {
        Route::get('/', 'Admin\BlogtagsController@index')->name('list');
        Route::get('/create', 'Admin\BlogtagsController@create')->name('create');
        Route::get('/edit/{id}', 'Admin\BlogtagsController@edit')->name('edit');
        Route::get('/delete/{id}', 'Admin\BlogtagsController@destroy')->name('delete');
        Route::put('/update/{product}', 'Admin\BlogtagsController@update')->name('update');
        Route::post('/store', 'Admin\BlogtagsController@store')->name('store');
        Route::get('/get', 'Admin\BlogtagsController@get')->name('get');
    });
});

Route::prefix('api/admin')->middleware(['api', 'admin'])->group(function () {
    Route::get('/stats', 'Admin\Api\AdminController@index');
    Route::get('/publishers/my', 'Admin\Api\PublisherController@my');
    Route::resource('/publishers', 'Admin\Api\PublisherController');
    Route::post('/publishers/approval/{id}', 'Admin\Api\PublisherController@approval');

    // Campaign Reports
    Route::get('/reports/options/{id}/{status}', 'Admin\Api\ReportsController@options');
    Route::resource('/reports', 'Admin\Api\ReportsController');

    // Contests Controller
    Route::resource('/contests', 'Admin\Api\ContestController');

    Route::resource('/campaigns', 'Admin\Api\CampaignController');
});

// Blog
Route::get('/blog', 'BlogController@index')->name('blog');
Route::get('/blog/{slug}', 'BlogController@show')->name('blog.post.url');
Route::get('/blog/archives/category/', 'BlogController@categoryAll')->name('categoryAll');
Route::get('/blog/category/{category}', 'BlogController@categoryPost')->name('categoryPost');
Route::get('/blog/archives/tag/', 'BlogController@tagAll')->name('tagAll');
Route::get('/blog/tag/{tag}', 'BlogController@tagPost')->name('tagPost');
