<?php

use App\Http\Controllers\AccomodationConditionAndPricingAndObjectController;
use App\Http\Controllers\AccomodationConditionAndPricingController;
use App\Http\Controllers\AccomodationTypeAndPricingController;
use App\Http\Controllers\AccomodationTypeController;
use App\Http\Controllers\Admin\DirectApplicationController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\MessagesArbitrController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Advertisements\AdvertisementsOrderController;
use App\Http\Controllers\Advertisements\AdvertisingTariffsController;
use App\Http\Controllers\Advertisements\RateAdvertisementController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Deal\DealController;
use App\Http\Controllers\Deal\RejectionDealController;
use App\Http\Controllers\Deal\ReviewDealController;
use App\Http\Controllers\DirectApplications\DirectApplicationsController;
use App\Http\Controllers\Estimate\EstimateController;
use App\Http\Controllers\Filter\AdditionTenderController;
use App\Http\Controllers\Filter\CityController;
use App\Http\Controllers\Filter\RegionController;
use App\Http\Controllers\Filter\RequirementInfrastructuresController;
use App\Http\Controllers\Filter\SportTypeController;
use App\Http\Controllers\Filter\TypeFoodController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncludedInAccomodationPricingController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ObjectTypeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OrdersAndPaymentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Profile\EventNotificationController;
use App\Http\Controllers\Profile\InfoCompanyController;
use App\Http\Controllers\Profile\PaymentDetailsController;
use App\Http\Controllers\Profile\PositionController;
use App\Http\Controllers\Profile\SendNotificationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SportObjectController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\Tender\ResponsesAndTenderController;
use App\Http\Controllers\Tender\ResponsesTenderController;
use App\Http\Controllers\Tender\TenderController;
use App\Models\Profile\InfoCompany;
use App\Models\Profile\PaymentDetails;
use App\Models\SportObject;
use Hizbul\SmsVerification\SmsVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Social Auth
/*Route::get('/sign-in/google', [App\Http\Controllers\SocialAuth\GoogleAuthController::class, 'google']);
Route::any('/sign-in/google/redirect', [App\Http\Controllers\SocialAuth\GoogleAuthController::class, 'googleRedirect']);

Route::get('/sign-in/vk', [App\Http\Controllers\SocialAuth\VkontakteAuthController::class, 'vkontakte']);
Route::any('/sign-in/vk/redirect', [App\Http\Controllers\SocialAuth\VkontakteAuthController::class, 'vkontakteRedirect']);*/

include __DIR__ . '/Admin.php';

Route::get('/invoice/', function () {
    return view('invoice');
});

Route::get('/payment-invoice', function () {
    return view('paymentInvoice');
});


/*Route::fallback(function () {
    return redirect()->to('/error');
});*/

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/', 'mainPage')->name('home');
Route::view('/terms', 'rulesPolitic')->name('terms');
Route::view('/contacts', 'contacts')->name('contacts');
Route::view('/news', 'news')->name('news');
Route::view('/object-catalog', 'objectCatalog')->name('object-catalog');
Route::view('/tender-catalog', 'tenderCatalog')->name('tender-catalog');
Route::view('/favorites-objects', 'favoritesObjects')->name('favorites-objects');
Route::view('/compare-objects', 'compareObjects')->name('compare-objects');
Route::view('/opportunities-cooperation', 'emails.cooperation')->name('opportunities-cooperation');

// Статические страницы
Route::view('/error', 'errors.ErrorNotFound')->name('error');
Route::view('/about', 'about')->name('about');
Route::view('/events', 'events')->name('events');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/site-map', 'siteMap')->name('site-map');

Route::middleware(['auth'])->group(function () {
    Route::post('/uploadImages/infrastruct', [SportObjectController::class, 'uploadImagesInfrastruct'])->name('upload-images-infrastruct');
    Route::get('/show', [InfrastructureController::class, 'index'])->name('infrastructure.index');
    Route::get('/options/list', [OptionController::class, 'index'])->name('options.index');
});

// Профиль пользователя
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/settings', [SettingsController::class, 'showProfile'])->name('profile.settings');
    Route::get('/notification', [SettingsController::class, 'showNotification'])->name('profile.notification');
    Route::get('/security', [SettingsController::class, 'showSecurity'])->name('profile.security');
    Route::get('/payment', [SettingsController::class, 'showPayment'])->name('profile.payment');
    Route::post('/changePassword', [ConfirmPasswordController::class, 'changePasswords'])->name('auth.changePassword');
    Route::post('/sendNotification/create', [SendNotificationController::class, 'store'])->name('sendNotification.create');
    Route::get('/sendNotification/destroy', [SendNotificationController::class, 'destroy'])->name('sendNotification.destroy');
});

// API маршруты
Route::prefix('api')->group(function () {
    Route::get('/info-company', [InfoCompanyController::class, 'getInfo'])->name('api.info-company');
    Route::get('/v1/get/coords', [SportObjectController::class, 'getCoords'])->name('api.get.coords');

    Route::group(['prefix' => 'filter'], function () {
        Route::get('/', [FilterController::class, 'getFiltersForSportObjects'])->name('api.filter.get');
        Route::get('/sport-types/list', [SportTypeController::class, 'index'])->name('api.filter.sport-types');
        Route::get('/requirement-infrastructures/list', [RequirementInfrastructuresController::class, 'index'])->name('api.filter.requirement-infrastructures');
        Route::get('/regions/list', [RegionController::class, 'index'])->name('api.filter.regions');
        Route::get('/type-foods/list', [TypeFoodController::class, 'index'])->name('api.filter.type-foods');
        Route::get('/additions/list', [AdditionTenderController::class, 'index'])->name('api.filter.additions');
        Route::get('/cities/list', [CityController::class, 'index'])->name('api.filter.cities');
    });

    // Спортивные объекты
    Route::prefix('sportObject')->group(function () {
        Route::put('/verify/{id}', [SportObjectController::class, 'verifyObject'])->name('sport-object.verify');
        Route::get('/show/{id}', [SportObjectController::class, 'show'])->name('sport-object.show');
        Route::put('/visible/{id}', [SportObjectController::class, 'showOrHidden'])->name('sport-object.visible');
        Route::delete('/delete/{id}', [SportObjectController::class, 'destroy'])->name('sport-object.delete');
    });
});

Route::post('/send-cooperation', [\App\Http\Controllers\CooperationController::class, 'mail']);
Route::get('object-catalog/{sportObject}', [SportObjectController::class, 'show']);
Route::get('/news/{newses}', [NewsController::class, 'show']);

// Авторизация
Route::prefix('auth')->group(function () {
    Route::get('/', [LoginController::class, 'formLogIn'])->name('user.welcome');
    Route::post('/', [LoginController::class, 'loginUser'])->name('welcome.login');
    Route::post('/customer', [LoginController::class, 'loginCustomer'])->name('auth.customer');
    Route::get('/registration', [RegisterController::class, 'showRegistrationForm'])->name('registration');
    Route::post('/registration', [RegisterController::class, 'create'])->name('user.create');
    Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::get('/current-user', [UsersController::class, 'getCurrentUser']);
    Route::get('/verify-message', [RegisterController::class, 'message'])->name('verify-message');
    Route::get('/verify-email/token/{token}/id/{id}', [RegisterController::class, 'verify'])->where('id', '[0-9]+')->name('verify-email');
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'form'])->name('forgot-form');
    Route::post('/forgot-password/mail', [ForgotPasswordController::class, 'mail'])->name('forgot-mail');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'form'])->name('password.reset.token');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
});

/*ЛК (Исполнитель)*/
Route::middleware('executor')->group(function () {
    Route::view('/rental-requests', 'profileExecutor.applicationForObjects');
    Route::view('/tender-responses', 'profileExecutor.responsesToTenders');

    Route::get('/api/users/sport-objects/count', function () {
        $countSportObjects = SportObject::query()->where('user_id', '=', Auth::id())->verify()->visible()->get()->count();
        if ($countSportObjects > 0) return 1;
        else return 0;
    });

    Route::prefix('sport-objects')->group(function () {
        Route::view('/', 'profileExecutor.sportObjects')->name('sport-objects.index');
        Route::view('/create', 'createObject')->name('sport-objects.create');
        Route::get('/edit/{sportObject}', [SportObjectController::class, 'showEdit'])->name('sport-objects.edit');
        Route::put('/update/{id}', [SportObjectController::class, 'update'])->name('sport-objects.update');

        Route::post('/advertisement/{id}/stop', [AdvertisementsOrderController::class, 'stopAdvertisement'])->name('sport-objects.advertisement.stop');
        Route::get('/advertisement/{id}/resume', [AdvertisementsOrderController::class, 'resumeAdvertisement'])->name('sport-objects.advertisement.resume');
    });

    Route::put('/api/tenders/responses', [ResponsesTenderController::class, 'getResponses']);
    Route::get('/api/v1/company/balance', [InfoCompanyController::class, 'getBalance']);

    Route::put('/accommodations/types', [AccomodationTypeAndPricingController::class, 'store']);
    Route::put('/accommodations/included-prices', [IncludedInAccomodationPricingController::class, 'store']);
    Route::put('/accommodations/condition-pricing', [AccomodationConditionAndPricingController::class, 'store']);

    Route::put('/sportObject/create', [SportObjectController::class, 'store']);
    Route::put('/sport-objects/{id}/soft-delete', [SportObjectController::class, 'destroy']);

    Route::post('/moveImage/{idObject}/{id}', [SportObjectController::class, 'moveImage']);
    Route::post('/removeImage', [SportObjectController::class, 'removeImage']);

    Route::post('/payments/create', [PaymentController::class, 'create'])->name('payment.create');
});

Route::any('/payments/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');

Route::put('/condPricing_and_object/create', [AccomodationConditionAndPricingAndObjectController::class, 'store']);


Route::get('/api/user/payment-details/{id}', function ($id) {
    $user = \App\Models\User::findOrFail($id);
    if ($user) {
        $payment = $user->paymentDetails;
        if ($payment) return response(["paymentDetails" => $payment]);
    }
    return response()->noContent();
});

Route::get('/api/user/payment-details', function () {
    if (Auth::user()) {
        $hasUserPayment = PaymentDetails::query()->where('user_id', '=', Auth::id())->get()->count();
        if ($hasUserPayment > 0) return 1;
        else return 0;
    } else return response()->noContent();
});
Route::get('/api/user/info-company', function () {
    $hasUserInfo = InfoCompany::query()->where('user_id', '=', Auth::id())->get()->count();
    if ($hasUserInfo > 0) return 1;
    else return 0;
});

/*ЛК (Заказчик)*/
Route::middleware('customer')->group(function () {
    Route::view('/my-rental-requests', 'requests.directRequest');

    /*Мои тендеры*/
    Route::put('/tender/to/archive', [TenderController::class, 'addTenderArchive']);

    Route::group(['prefix' => 'tenders'], function () {
        Route::view('/my-tenders', 'profileCustomer.applicationForTenders');
        Route::put('/my-tenders', [TenderController::class, 'getMyTenders']);
        Route::post('/{tenderId}/responses/reject-all', [TenderController::class, 'rejectAllResponses']);

        Route::put('/update/{id}', [TenderController::class, 'update']);
    });

    /**Прямые заявки*/
    Route::put('/direct_application/update/{id}', [DirectApplicationsController::class, 'update']);
});

Route::get('/deals_reviews/list', [ReviewDealController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::put('/api/payments', [EstimateController::class, 'getPayments']);
    Route::get('/api/payments/statistic', [EstimateController::class, 'getPaymentsStatistic']);

    Route::put('/user/update', [UsersController::class, 'updateStatus']);
    Route::put('/user/block', [UsersController::class, 'setBlock']);

    Route::view('/orders-and-payments', 'profileCustomer.ordersAndPayments');
    Route::view('/messages', 'messages');

    Route::group(['prefix' => 'reviews'], function () {
        Route::view('/', 'profileCustomer.reviews');
        Route::put('/data', [ReviewDealController::class, 'getReviews']);
    });

    Route::put('/active-orders', [OrdersAndPaymentsController::class, 'getActiveOrders']);
    Route::put('/finished-orders', [OrdersAndPaymentsController::class, 'getFinishedOrders']);
    Route::put('/orders', [OrdersAndPaymentsController::class, 'getOrders']);
    Route::put('/estimates', [OrdersAndPaymentsController::class, 'getEstimates']);
    Route::put('/direct-applications', [DirectApplicationsController::class, 'getApplicationsForProfile']);

    Route::post('/create/newCity', [CityController::class, 'newRegion']);
    Route::post('/uploadLogo/{id}', [InfoCompanyController::class, 'uploadImageLogo']);

    Route::group(['prefix' => 'transaction'], function () {
        Route::put('/deals', [DealController::class, 'index']);
        Route::get('/estimate/{id}', [EstimateController::class, 'getEstimateById']);
        Route::get('/estimates', [EstimateController::class, 'index']);
        Route::put('/estimate/create', [EstimateController::class, 'store']);
        Route::put('/deal_estimate/update/', [EstimateController::class, 'update']);
        Route::put('/estimate/show_customer/{id}', [EstimateController::class, 'showCustomer']);
        Route::put('/estimate/confirm_payment/{id}', [EstimateController::class, 'confirmPayment']);
        Route::put('/estimate/confirm_payment_admin/{id}/{deal_id}', [EstimateController::class, 'confirmPaymentAdmin']);
        Route::post('/estimate/uploadPayment/{id}/{estimateId}', [EstimateController::class, 'uploadDocumentPayment']);

    });

    Route::put('/invoices/download/', [InvoiceController::class, "download"]);
    Route::put('/invoice-payment/download/', [InvoiceController::class, "paymentDownload"]);

    Route::get('/deal/rejection_deals/list', [RejectionDealController::class, 'index']);
    Route::get('/transaction/deal/{id}', function ($id) {
        $deal = \App\Models\Deal\Deal::query()->hasUser()->find($id);
        if ($deal && $deal->tender()->exists())
            return view('conclusionOfTransaction', compact('id'));
        else if ($deal && $deal->direct()->exists()) return view('conclusionOfTransactionDirect', compact('id'));

        return response()->noContent();
    });

    Route::get('/transaction/deal/getDealDirect/{id}', [DealController::class, 'getDealDirect']);
    Route::get('/transaction/deal/tender/{id}', [DealController::class, 'getDealTender']);
    Route::put('/transaction/deal/tender/create', [DealController::class, 'store']);
    Route::put('/transaction/deal/direct/create', [DealController::class, 'storeDirect']);
    Route::put('/transaction/deal/reject/{id}', [DealController::class, 'reject']);
    Route::put('/transaction/deal/condition/accept/{id}', [DealController::class, 'accept']);


    Route::put('/transaction/deal/connect-arbitr/{id}', [DealController::class, 'connectArbitration']);
    Route::put('/transaction/deal/get-payment/{id}', [DealController::class, 'dealGetPayment']);
    Route::put('/transaction/deal/done/{id}', [DealController::class, 'dealDone']);
    Route::put('/transaction/deal/complete/{id}', [DealController::class, 'dealCompleteWithReview']);

    /**Спортивные объекты*/
    Route::post('/uploadImages', [SportObjectController::class, 'uploadImages']);

    /**Отзывы*/
    Route::put('/review/create', [ReviewDealController::class, 'store']);
    Route::put('/review/verify/{id}', [ReviewDealController::class, 'verify']);
    Route::put('/review/refused/{id}', [ReviewDealController::class, 'refused']);
    Route::delete('/review/delete/{id}', [ReviewDealController::class, 'destroy']);

    /**Сделка*/
    Route::get('/transaction/conclusion/deal/{id}', [DealController::class, 'getDeal']);

    Route::get('/messages_arbitr/list', [MessagesArbitrController::class, 'index']);
    Route::put('/messages_arbitr/create', [MessagesArbitrController::class, 'store']);

    /**Получение данных*/
    Route::get('/service/list', [ServiceController::class, 'index']);

});

Route::view('/create/tender', 'requests.addTenderPage')->middleware(['nonAuth']);


/*--------------*/

Route::get('/api/v1/filters', [FilterController::class, 'getFilters']);
Route::get('/api/v1/data/response', [FilterController::class, 'getDataResponseRequest']);

Route::get('/api/v1/country/list', [CountryController::class, 'index']);
Route::get('/position/list', [PositionController::class, 'index']);


Route::get('/accomodation-type/list', [AccomodationTypeController::class, 'index']);
Route::get('/accomodation-type-pricing/list', [AccomodationTypeAndPricingController::class, 'index']);
Route::get('/infrastructure/list', [InfrastructureController::class, 'index']);
Route::get('/options/list', [OptionController::class, 'index']);
Route::get('/notifications/list', [EventNotificationController::class, 'indexFetch']);
Route::get('/event-notifications/list', [EventNotificationController::class, 'index']);

Route::put('/tenders/create', [TenderController::class, 'store']);
Route::put('/direct-application/create', [DirectApplicationsController::class, 'store']);

Route::get('/payment-details/list', [PaymentDetailsController::class, 'index']);
Route::get('/payment-details/user', [PaymentDetailsController::class, 'getByUser']);

Route::put('/payment-details/update', [PaymentDetailsController::class, 'update']);
Route::put('/info-company/update', [InfoCompanyController::class, 'store']);

Route::put('/direct_application/to/archive/', [DirectApplicationsController::class, 'addDirectApplicationsArchive']);

Route::get('/company/verify/{id}', [InfoCompanyController::class, 'getStatusVerify']);

Route::get('/get/geocoder', [SportObjectController::class, 'getAddress']);

/*Route::post('/sms-verification', function (Request $request) {
    return response()->json(SmsVerification::sendCode($request->input('phoneNumber')));
});*/

/*Route::post('/sms-verification', function (Request $request) {
    return response()->json(SmsVerification::sendCode($request->input('phone')));
});

Route::get('/sms-verification/{code}/{phone}', function ($code, $phoneNumber) {
    return response()->json(SmsVerification::checkCode($code, $phoneNumber));
});*/


Auth::routes(['verify' => true]);
Route::get('/email/verify', function () {
    return view('emails.verify');
})->name('email.verify');

Auth::routes();


Route::group(['prefix' => 'api'], function () {
    Route::get('/reviews/sport-object/{id}', [ReviewDealController::class, 'getPaginatedReviews']);

    Route::group(['prefix' => 'stats'], function () {
        Route::get('/orders', [StatisticController::class, 'getStatisticsForOrders']);
        Route::get('/directs', [StatisticController::class, 'getStatisticsByDirect']);
        Route::get('/sport-objects', [StatisticController::class, 'getStatisticsBySportObjects']);
        Route::get('/tenders', [StatisticController::class, 'getStatisticsByTenders']);
        Route::get('/my-tenders', [StatisticController::class, 'getMyStatisticsByTenders']);
        Route::get('/tender/responses', [StatisticController::class, 'getStatisticsByResponsesTender']);
        Route::get('/messages/unread', [StatisticController::class, 'getStatisticByMessages']);
    });

    Route::group(['prefix' => 'filter'], function () {
        Route::group(['prefix' => 'sport-object'], function () {
            Route::get('/services/list', [ServiceController::class, 'getServicesInObjects']);
            Route::get('/type-sports/list', [SportTypeController::class, 'getSportTypesInObjects']);
            Route::get('/infrastructures/list', [InfrastructureController::class, 'getInfrastructuresInObjects']);
            //  Route::get('/regions/list', [RegionController::class, 'getRegionsInObjects']);
        });
    });

    Route::group(['prefix' => 'sport-objects'], function () {
        Route::put('/', [SportObjectController::class, 'index']);
        Route::put('/similar', [SportObjectController::class, 'getSimilarSportObjects']);
        Route::post('/popular', [SportObjectController::class, 'getPopularSportObjects']);
        Route::get('/without-page', [SportObjectController::class, 'getSportObjectsWithoutPage']);
        Route::put('/user', [SportObjectController::class, 'getSportObjectsByUser']);
        Route::get('/user/{id}', [SportObjectController::class, 'getSportObjectsByUserId']);
    });

    Route::get('/favourites', [SportObjectController::class, 'getFavourites']);

    Route::group(['prefix' => 'news'], function () {
        Route::put('/', [NewsController::class, 'index']);
        Route::put('/{news}', [NewsController::class, 'show']);
        Route::get('/storage/image/{name}', [NewsController::class, 'showImage']);
    });

    Route::group(['prefix' => 'tenders'], function () {
        Route::put('/', [TenderController::class, 'index']);
    });

    Route::group(['prefix' => 'responses-tender'], function () {
        Route::put('/store', [ResponsesTenderController::class, 'store']);
        Route::put('/update', [ResponsesTenderController::class, 'update']);
        Route::put('/delete', [ResponsesTenderController::class, 'delete']);
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('/contacts', [ChatController::class, 'getContacts']);
        Route::get('/messages/from/{id}', [ChatController::class, 'getMessageFrom']);
        Route::get('/messages/read/{id}', [ChatController::class, 'getMessageRead']);
        Route::post('/message/add', [ChatController::class, 'sendMessage']);
        Route::get('/messages/delete/{id}', [ChatController::class, 'deleteMessageFor']);
        Route::post('/message/image-upload', [ChatController::class, 'uploadImage']);
        //Route::post('/message/remove', [\App\Http\Controllers\ChatController::class, 'uploadImage']);
    });

    Route::group(['prefix' => 'object'], function () {
        Route::get('/object-types', [ObjectTypeController::class, 'index']);
    });

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/positions', [PositionController::class, 'index']);
    Route::get('/accType', [AccomodationTypeController::class, 'index']);
    Route::get('/advertising_tariffs', [AdvertisingTariffsController::class, 'index']);
});

Route::group(['prefix' => 'storage/listings'], function () {
    Route::get('/objects/temp/{name}', [SportObjectController::class, 'showImageTempObject']);
    Route::get('/objects/{id}/{name}', [SportObjectController::class, 'showImageObject']);
    Route::get('/logos/{id}/{name}', [InfoCompanyController::class, 'showLogo']);
    Route::get('/infrastruct/{name}', [SportObjectController::class, 'showImageInfarstruct']);
    Route::get('/payment/{id}/{name}', [EstimateController::class, 'showImage']);
    Route::get('/estimate/{id_deal}/{id_estm}', [EstimateController::class, 'showInvoice']);
    Route::get('/payment-invoice/{id_deal}/{id_estm}', [EstimateController::class, 'showPaymentInvoice']);
    Route::get('/message-image/{name}', [ChatController::class, 'showImage']);
});


/*Route::prefix('api/tasks', )->group(function () {
    Route::get('/watch-advertisements', [\App\Http\Controllers\TaskController::class, 'watchAdvertisements']);
});*/
