<?php

use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\NominationElectionController;
use Illuminate\Support\Facades\Route;

Route::post('/customer-register', [CustomerController::class, 'registerCustomer'])->name('customer.register');
Route::get('success-transaction', [CustomerController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [CustomerController::class, 'cancelTransaction'])->name('cancelTransaction');


Route::get('/customer-register', [CustomerController::class, 'customerRegistrationPage'])->name('frontend.customer.register');
Route::get('/customer/account/confirm', [CustomerController::class, 'verifyCustomerEmail'])->name('customer.email.verify');
Route::get('/customer/account/reset/password', [CustomerController::class, 'resetCustomerPassword'])->name('customer.password.reset');
Route::post('/customer/account/update/password', [CustomerController::class, 'updateCustomerPassword'])->name('customer.update.password');

// Authentication

Route::get('/membership-register/{uid}', [CustomerController::class, 'membershipRegister'])->name('frontend.membership.register');
Route::post('/customer/login', [CustomerAuthController::class, 'validateCustomer'])->name('customer.account.validate');
Route::post('/customer/password/reset', [CustomerAuthController::class, 'sendResetPasswordLink'])->name('customer.reset.password');
Route::get('/customer-survey/{program_uuid}', [CustomerController::class, 'customerSurvey'])->name('customer.survey');
Route::get('/customer-optional-survey/{optional_uuid}', [CustomerController::class, 'customerOptionalSurvey'])->name('customer.optional.survey');

Route::post('/submit-survey', [CustomerController::class, 'submitSurvey'])->name('customer.submit.survey');
Route::post('/optional-submit-survey', [CustomerController::class, 'optionalSubmitSurvey'])->name('customer.optional.submit.survey');
Route::get('/non-member-survey/{survey_uuid}', [CustomerController::class, 'nonMemberSurvey'])->name('non.member.survey');
Route::post('/non-member-submit-survey', [CustomerController::class, 'nonMemberSubmitSurvey'])->name('non.member.submit.survey');

Route::group(['middleware' => ['auth:customer']], function () {
    Route::get('/customer/logout', [CustomerAuthController::class, 'logoutCustomer'])->name('customer.logout');
    Route::get('/customer-dashboard', [CustomerController::class, 'customerDashboard'])->name('customer.home');
    Route::post('/customer-profile-update', [CustomerController::class, 'customerProfileUpdate'])->name('customer.profile.update');
    Route::post('upgrade-payment', [CustomerController::class, 'upgradePayment'])->name('upgradePayment');
    Route::get('/nomination', [NominationElectionController::class, 'nomination'])->name('frontend.nomination');
    Route::post('/submit-nomination', [NominationElectionController::class, 'submit_nomination'])->name('frontend.submit.nomination');

    // Election Module
    Route::get('/election', [NominationElectionController::class, 'electionDetails'])->name('frontend.election');
    Route::get('/election/get-customers-for-voting', [NominationElectionController::class, 'getCustomersForVoting'])->name('get-customers-for-voting');
    Route::post('/election/elect-vote', [NominationElectionController::class, 'electVote'])->name('customer-elect-vote');

    Route::get('/survey-details', [CustomerController::class, 'surveyDetails'])->name('frontend.survey.details');
});
