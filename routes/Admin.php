<?php

use App\Http\Controllers\Admin\DirectApplicationController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Advertisements\AdvertisementsOrderController;
use App\Http\Controllers\Advertisements\RateAdvertisementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DirectApplications\DirectApplicationsController;
use App\Http\Controllers\Estimate\EstimateController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\SportObjectController;
use App\Http\Controllers\Tender\ResponsesAndTenderController;
use Illuminate\Support\Facades\Route;

Route::post('/admin/auth', [LoginController::class, 'authenticateAdmin'])
    ->name('admin.auth');
Route::get('/admin/auth', [LoginController::class, 'loginAdmin'])->name('admin.login');
Route::get('/admin', [LoginController::class, 'loginAdmin']);

Route::prefix('admin')->middleware('auth.admin')->group(function () {
    #region Пользователи
    Route::group(['prefix' => 'users'], function () {
        Route::view('/customers', 'adminPanel.customers')->name('admin.customers');
        Route::view('/executors', 'adminPanel.home')->name('admin.executors');
        Route::get('/profile/{user}', [UsersController::class, 'showProfile']);
        //Route::get('/requests-and-responses/{user}', [UsersController::class, 'showRequests']);
    });
    Route::delete('/user/{id}/delete', [UsersController::class, 'destroy']);

    Route::get('/applications/tender/show/{id}', function ($id) {
        return view('adminPanel.applications.show_tender', compact('id'));
    });

    Route::group(['prefix' => 'performers'], function () {
        Route::view('/', 'adminPanel.performers.profileAndSettings');
        Route::view('/applications', 'adminPanel.performers.directApplications');
        Route::view('/deals', 'adminPanel.performers.deals');
        Route::view('/price', 'adminPanel.performers.costEstimate');
        Route::view('/reviews', 'adminPanel.performers.reviews');
        Route::view('/correspondence', 'adminPanel.performers.correspondence');
    });

    /**Спортивные объекты*/
    Route::group(['prefix' => 'sport-objects'], function () {
        Route::view('/checked', 'adminPanel.sports-objects-checked');
        Route::view('/checking', 'adminPanel.sports-objects-checking')->name("admin.sport-objects.checking");

        Route::get('/addresses', [\App\Http\Controllers\Admin\SportObjectController::class, "getAddressesSportObjects"]);
        Route::get('/show/{sportObject}', [\App\Http\Controllers\Admin\SportObjectController::class, "show"]);
        Route::get('/{id}', [\App\Http\Controllers\Admin\SportObjectController::class, "getSportObjectId"]);
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\SportObjectController::class, "edit"]);
        Route::put('/update/{id}', [SportObjectController::class, 'update']);
        // Route::get('/pre-show/{id}', [\App\Http\Controllers\Admin\SportObjectController::class, "showAdminObject"]);
    });

    /** Сделки*/
    Route::group(['prefix' => 'deals'], function () {
        Route::view('/processing', 'adminPanel.deals_processing')->name("admin.deals.processing");
        Route::view('/in_progress', 'adminPanel.deals_in_progress');
        Route::view('/finished', 'adminPanel.deals_finished');
        Route::get('/show/{id}', function ($id) {
            return view('adminPanel.deals.show_deal', compact('id'));
        });
    });

    /**Финансовые операции*/
    Route::view('/finantial_operations_payment_bills', 'adminPanel.finantial_operations_payment_bills')->name("admin.finantial_operations_payment_bills");
    Route::view('/finantial_operations_payment_advertisment_bills', 'adminPanel.finantial_operations_payment_advertisment_bills');
    Route::view('/finantial_operations_payment_emploees_bills', 'adminPanel.finantial_operations_payment_emploees_bills');
    Route::view('/finantial_operations_payment_ins_and_outs', 'adminPanel.finantial_operations_payment_ins_and_outs');

    Route::post('/estimate/{id}/payment', [EstimateController::class, 'notificationPayment']);

    /**Реклама и продвижение*/
    Route::view('/advertisment_and_seo_orders', 'adminPanel.advertisment_and_seo_orders');
    Route::view('/advertisment_and_seo_price', 'adminPanel.advertisment_and_seo_price')->name("admin.advertisment_and_seo_price");

    /** Сметы и счета*/
    Route::view('/bills_list', 'adminPanel.bills_list')->name("admin.bills_list");

    /** Заявки*/
    Route::view('/applications/direct', 'adminPanel.admin_application_direct')->name("admin.applications.direct");
    Route::view('/applications/tender', 'adminPanel.admin_application_tender');

    Route::get('/applications/direct/list', [DirectApplicationController::class, 'index']);
    Route::get('/applications/direct/{id}', [DirectApplicationController::class, 'getDirectById']);
    Route::get('/applications/tender/list', [\App\Http\Controllers\Admin\TenderController::class, 'index']);
    Route::get('/applications/tender/{id}', [\App\Http\Controllers\Admin\TenderController::class, 'getTenderById']);
    Route::get('/applications/tender/show/{id}', function ($id) {
        return view('adminPanel.applications.show_tender', compact('id'));
    });
    Route::get('/applications/direct/show/{id}', function ($id) {
        return view('adminPanel.applications.show_direct', compact('id'));
    });

    Route::delete('/direct_application/delete/{id}', [DirectApplicationsController::class, 'destroy']);

    Route::put('/direct_applications/update/{id}', [DirectApplicationsController::class, 'update']);
    Route::put('/applications/tender/update/{id}', [\App\Http\Controllers\Admin\TenderController::class, 'update']);

    Route::get('/responses-and-tenders/list', [ResponsesAndTenderController::class, 'index']);
    Route::get('/responses-and-tenders/{id}/list', [ResponsesAndTenderController::class, 'getResponsesByTender']);

    /**Отзывы*/
    Route::view('/cooperation_feedbacks_moderating', 'adminPanel.cooperation_feedbacks_moderating')->name("admin.cooperation_feedbacks_moderating");
    Route::view('/cooperation_feedbacks_accepted', 'adminPanel.cooperation_feedbacks_accepted');
    Route::view('/cooperation_feedbacks_refused', 'adminPanel.cooperation_feedbacks_refused');

    /**Новости*/
    Route::view('/news', 'adminPanel.news')->name("admin.news");
    Route::view('/news/add', 'adminPanel.news.add_news');

    /**Настройки*/
    Route::view('/payment-details', 'adminPanel.paymentDetails')->name("admin.payment-details");
    Route::post('/settings/save', [\App\Http\Controllers\Admin\SettingsController::class, 'saveSettings']);
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'getSettings']);
    Route::post('/settings/uploadLogo', [\App\Http\Controllers\Admin\SettingsController::class, 'uploadImageLogo']);
    Route::post('/settings/uploadPrint', [\App\Http\Controllers\Admin\SettingsController::class, 'uploadImagePrint']);
    Route::post('/settings/uploadSignature', [\App\Http\Controllers\Admin\SettingsController::class, 'uploadImageSignature']);

    Route::group(['prefix' => 'api'], function () {
        Route::get('/users/list', [UsersController::class, 'index']);

        Route::group(['prefix' => 'sport-objects'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\SportObjectController::class, 'index']);
            Route::get('/statistic', [\App\Http\Controllers\Admin\SportObjectController::class, 'statistic']);
        });

        Route::group(['prefix' => 'deals'], function () {
            Route::put('/', [\App\Http\Controllers\Admin\DealController::class, 'index']);
        });

        Route::group(['prefix' => 'feedbacks'], function () {
            Route::put('/', [FeedbackController::class, 'index']);
        });

        Route::group(['prefix' => 'bills'], function () {
            Route::put('/', [\App\Http\Controllers\Admin\EstimateController::class, 'index']);
        });

        Route::group(['prefix' => 'news'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\NewsController::class, 'index']);
            Route::get('/{news}', [\App\Http\Controllers\Admin\NewsController::class, 'show']);
            Route::get('/{news}/edit', [\App\Http\Controllers\Admin\NewsController::class, 'edit']);
            Route::post('/store', [\App\Http\Controllers\Admin\NewsController::class, 'store']);
            Route::post('/update/{id}', [\App\Http\Controllers\Admin\NewsController::class, 'update']);
            Route::post('/uploadImage', [\App\Http\Controllers\Admin\NewsController::class, 'uploadImage']);
            Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\NewsController::class, 'destroy']);
        });

        Route::group(['prefix' => 'transaction'], function () {
            Route::get('/payments', [\App\Http\Controllers\Admin\EstimateController::class, 'getPayments']);
        });

        Route::group(['prefix' => 'advertisements'], function () {
            Route::get('/', [AdvertisementsOrderController::class, 'getAdvertisements']);
            Route::get('/payments', [AdvertisementsOrderController::class, 'getPaymentAdvertisements']);
            Route::post('/tariff/update/{id}', [RateAdvertisementController::class, 'update']);
            Route::post('/tariff/price/update/{id}', [RateAdvertisementController::class, 'updatePrice']);
        });

        Route::group(['prefix' => 'statistic'], function () {
            Route::get('/main', [\App\Http\Controllers\Admin\StatisticController::class, 'getStatisticByMain']);
            Route::get('/users', [\App\Http\Controllers\Admin\StatisticController::class, 'getStatisticByUsers']);
            Route::get('/finance', [\App\Http\Controllers\Admin\StatisticController::class, 'getStatisticByFinance']);
            Route::get('/finance-income', [\App\Http\Controllers\Admin\StatisticController::class, 'getStatisticByIncomeFinance']);
        });
    });
});
