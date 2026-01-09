<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\ContentController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\EventSurveyCertificateController;
use App\Http\Controllers\Dashboard\EventWorkshopController;
use App\Http\Controllers\Dashboard\HomePageController;
use App\Http\Controllers\Dashboard\LocationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\MediaManager\MediaManagerController;
use App\Http\Controllers\Dashboard\MediaManager\MediaController;
use App\Http\Controllers\Dashboard\MembershipController;
use App\Http\Controllers\Dashboard\WebSettingController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\NewsController;
use App\Http\Controllers\Dashboard\NominationController;
use App\Http\Controllers\Dashboard\OurTeamCategoryController;
use App\Http\Controllers\Dashboard\OurTeamController;
use App\Http\Controllers\Dashboard\OurTeamListingController;
use App\Http\Controllers\Dashboard\ResourceController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\EventDetailsController;
use Barryvdh\Debugbar\DataCollector\EventCollector;

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

Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/search-details', [FrontendController::class, 'searchDetails'])->name('frontend.search.details');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/our-team', [FrontendController::class, 'ourTeam'])->name('frontend.our.team');
Route::get('/our-team/cat/listing', [FrontendController::class, 'ourTeamCatListings'])->name('frontend.our.team.cat.listings.get');
Route::get('/our-team/{uid}/{slug}', [FrontendController::class, 'ourTeamDetails'])->name('frontend.our.team.details');
Route::get('/resources', [FrontendController::class, 'resources'])->name('frontend.resources');
Route::get('/news-events', [FrontendController::class, 'newsAndEvents'])->name('frontend.news.events');
Route::get('/membership', [FrontendController::class, 'membership'])->name('frontend.membership');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::post('/submit-contact', [FrontendController::class, 'submitContactQuery'])->name('frontend.submit.contact');
Route::post('/subscriber-email', [FrontendController::class, 'subscriberEmail'])->name('frontend.subscriber.email');
Route::get('/reload-captcha', [FrontendController::class, 'reloadCaptcha'])->name('captcha.reload');

Route::get('/event-register/{uuid}', [EventDetailsController::class, 'eventRegister'])->name('frontend.event.register');
Route::get('/event-details/{slug}', [EventDetailsController::class, 'eventDetails'])->name('frontend.event.details');
Route::get('/featured-speaker-details/{id}', [EventDetailsController::class, 'featuredSpeakerDetails'])->name('frontend.featured.speaker.details');
Route::get('/check-program', [EventDetailsController::class, 'checkProgram'])->name('frontend.check.program');
Route::post('/event-registration', [EventDetailsController::class, 'eventRegistration'])->name('frontend.event.registration');
Route::post('/retry-event-registration', [EventDetailsController::class, 'retryEventRegistration'])->name('frontend.retry.event.registration');
Route::get('/news-details/{slug}', [EventDetailsController::class, 'newsDetails'])->name('frontend.news.details');

// Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    Auth::routes();
});
Route::post('admin/validate-login', [LoginController::class, 'validate_login'])->name('admin.validate.login');
Route::post('admin/check-login', [LoginController::class, 'check_login'])->name('admin.check.login');
Route::get('admin/check-login', function(){
    return redirect()->route('login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/home', 'HomeController@index')->name('adminHome');
    Route::get('admin/profile', 'ProfileController@index')->name('profile');
    Route::put('admin/profile', 'ProfileController@update')->name('profile.update');

    /* ---- Media Manager Routes  */
    Route::prefix('admin/media-manager')->group(function () {
        Route::post('/delete', [MediaController::class, 'destroy'])->name('admin.media-manager.destroy');
        Route::get('/', [MediaController::class, 'index'])->name('admin.media-manager.form');
        Route::get('/index', [MediaManagerController::class, 'index'])->name('admin.media-manager');
        Route::post('/upload', [MediaController::class, 'do_upload'])->name('admin.media-manager.upload');
        Route::post('/update-all', [MediaManagerController::class, 'update_all'])->name('admin.media-manager.update-all');
        Route::post('/get-media-data', [MediaManagerController::class, 'get_media_data'])->name('admin.media-manager.get-media-data');
        Route::post('/check-media-data', [MediaManagerController::class, 'check_media_data'])->name('admin.media-manager.check-media-data');
        Route::post('/filename-change', [MediaManagerController::class, 'media_file_change'])->name('admin.media.filename_change');
        Route::post('/alttag-change', [MediaManagerController::class, 'media_alttag_change'])->name('admin.media.alttag_change');
        Route::post('/pdf-upload', [MediaManagerController::class, 'pdf_upload'])->name('admin.media-manager.pdf-upload');
    });
    /* ---- End of Media Manager Route */

    // Setting Route 
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('websetting', WebSettingController::class);
        Route::resource('menu', MenuController::class);
        Route::get('/check-unique-page-slug', [CommonController::class, 'check_unique_page_slug'])->name('admin.check.unique.page.slug');
    });

    // Our teams Route 
    Route::prefix('admin/our-teams')->group(function () {
        Route::get('/', [OurTeamController::class, 'index'])->name('admin.our_teams');
        Route::get('/create', [OurTeamController::class, 'create'])->name('admin.our_teams.create');
        Route::post('/store', [OurTeamController::class, 'store'])->name('admin.our_teams.store');
        Route::get('/edit/{uid}', [OurTeamController::class, 'edit'])->name('admin.our_teams.edit');
        Route::post('/update', [OurTeamController::class, 'update'])->name('admin.our_teams.update');
        Route::post('/delete', [OurTeamController::class, 'delete'])->name('admin.our_teams.delete');
        Route::get('/category/index', [OurTeamController::class, 'index'])->name('admin.our_teams.category');

        Route::prefix('/category')->group(function () {
            Route::get('/index', [OurTeamCategoryController::class, 'index'])->name('admin.our_teams.category');
            Route::get('/create', [OurTeamCategoryController::class, 'create'])->name('admin.our_teams.category.create');
            Route::post('/store', [OurTeamCategoryController::class, 'store'])->name('admin.our_teams.category.store');
            Route::get('/edit', [OurTeamCategoryController::class, 'edit'])->name('admin.our_teams.category.edit');
            Route::post('/update', [OurTeamCategoryController::class, 'update'])->name('admin.our_teams.category.update');
            Route::post('/delete', [OurTeamCategoryController::class, 'destroy'])->name('admin.our_teams.category.delete');
        });

        Route::get('/list/index', [OurTeamListingController::class, 'index'])->name('admin.our_teams.list');
        Route::get('/list/create', [OurTeamListingController::class, 'create'])->name('admin.our_teams.list.create');
        Route::post('/list/store', [OurTeamListingController::class, 'store'])->name('admin.our_teams.list.store');
        // Route::post('/list/update-all/', [OurTeamListingController::class, 'update_all'])->name('admin.our_teams.list.update-all');

        Route::get('/list/edit/{uid}', [OurTeamListingController::class, 'edit'])->name('admin.our_teams.list.edit');
        Route::post('/list/update', [OurTeamListingController::class, 'update'])->name('admin.our_teams.list.update');
        Route::post('/list/delete', [OurTeamListingController::class, 'delete'])->name('admin.our_teams.list.delete');
        Route::post('/list/sort', [OurTeamListingController::class, 'sortTeamListing'])->name('admin.our_teams.sort');
    });


    // Role route

    Route::group(['prefix' => 'admin'], function () {
        // Role manager
        Route::get('manage/roles', [RoleController::class, 'manageRoles'])->name('admin.roles.manage');
        Route::get('manage/role/edit/{id}', [RoleController::class, 'editRole'])->name('admin.role.edit');
        Route::put('role/update', [RoleController::class, 'updateRole'])->name('admin.role.update');
        Route::get('role/create', [RoleController::class, 'createRole'])->name('admin.role.create');
        Route::post('role/create', [RoleController::class, 'storeRole'])->name('admin.role.store');
        Route::post('role/delete', [RoleController::class, 'deleteRole'])->name('admin.role.delete');

        // User manager

        Route::get('manage/users', [UserController::class, 'manageUsers'])->name('admin.users.manage');
        Route::get('manage/user/edit/{id}', [UserController::class, 'editUser'])->name('admin.user.edit');
        Route::put('user/update', [UserController::class, 'updateUser'])->name('admin.user.update');
        Route::get('user/create', [UserController::class, 'createUser'])->name('admin.user.create');
        Route::post('user/create', [UserController::class, 'storeUser'])->name('admin.user.store');
        Route::post('user/delete', [UserController::class, 'deleteUser'])->name('admin.user.delete');
        Route::post('user/reset-2fa', [UserController::class, 'reset2fa'])->name('admin.reset.2fa');

        // Content manager
        Route::get('manage/contents', [ContentController::class, 'manageContents'])->name('admin.contents.manage');
        Route::get('content/create/{id}/{slug}', [ContentController::class, 'createContent'])->name('admin.content.create');
        Route::post('content/page/delete/', [ContentController::class, 'deleteContent'])->name('admin.content.page.delete');




        // About card save 

        Route::post('about/card/create', [ContentController::class, 'createAboutTempCard'])->name('admin.content.about.temp.card.create');
        Route::post('about-page/card/create', [ContentController::class, 'createAboutCard'])->name('admin.content.about.card.create');
        Route::post('about-page/card/edit', [ContentController::class, 'editAboutCard'])->name('admin.content.about.card.edit');
        Route::post('about-page/card/update', [ContentController::class, 'updateAboutCard'])->name('admin.content.about.card.update');
        Route::post('about-page/card/delete', [ContentController::class, 'deleteAboutCard'])->name('admin.content.about.card.delete');
        Route::post('about/page/create', [ContentController::class, 'createAboutPage'])->name('admin.content.about-page.create');
        Route::get('about/page/edit/{id}', [ContentController::class, 'editAboutPage'])->name('admin.content.about-page.edit');
        Route::post('about/page/update', [ContentController::class, 'updateAboutPage'])->name('admin.content.about-page.update');
        Route::post('about/page/delete', [ContentController::class, 'deleteAboutPage'])->name('admin.content.about-page.delete');



        // Home section

        Route::post('home/page/slider/create', [HomePageController::class, 'createSlider'])->name('admin.content.home.slider.create');
        Route::post('home/page/slider/update', [HomePageController::class, 'updateSlider'])->name('admin.content.home.slider.update');
        Route::post('home/page/sections/edit', [HomePageController::class, 'editHomeSections'])->name('admin.content.home.sections.edit');
        Route::post('home/page/sections/delete', [HomePageController::class, 'deleteHomeSections'])->name('admin.content.home.sections.delete');

        Route::post('home/page/first/card/create', [HomePageController::class, 'createCard'])->name('admin.content.home.first.card.create');
        Route::post('home/page/first/card/update', [HomePageController::class, 'updateCard'])->name('admin.content.home.first.card.update');

        Route::post('home/page/partner/create', [HomePageController::class, 'createPartner'])->name('admin.content.home.partner.create');
        Route::post('home/page/partner/update', [HomePageController::class, 'updatePartner'])->name('admin.content.home.partner.update');

        Route::post('home/page/final/card/create', [HomePageController::class, 'createFinalSectionCard'])->name('admin.content.home.final.card.create');
        Route::post('home/page/final/card/update', [HomePageController::class, 'updateFinalSectionCard'])->name('admin.content.home.final.card.update');


        Route::post('home/page/validate/cards', [HomePageController::class, 'validateHomePageCard'])->name('admin.content.home.allsectioncard.required.validate');

        Route::post('home/page/create', [HomePageController::class, 'createHomePage'])->name('admin.content.home.page.create');
        Route::post('home/page/update', [HomePageController::class, 'updateHomePage'])->name('admin.content.home.page.update');
        Route::get('home/page/edit/{id}', [HomePageController::class, 'editHomePage'])->name('admin.home.page.edit');




        // Event management
        Route::get('manage/events', [EventController::class, 'manageEvents'])->name('admin.manage.events');

        Route::post('delete/event', [EventController::class, 'deleteEvent'])->name('admin.event.delete');

        Route::get('event/create', [EventController::class, 'createEvent'])->name('admin.event.create');
        Route::post('event/create', [EventController::class, 'storeEvent'])->name('admin.event.store');
        // Route::post('event/workshops/create',[EventController::class,'storeEventWorkshop'])->name('admin.save.event.workshop');
        Route::get('event/edit/{slug}', [EventController::class, 'editEvent'])->name('admin.event.edit');
        Route::post('event/update', [EventController::class, 'updateEvent'])->name('admin.event.update');
        Route::post('event/image/delete', [EventController::class, 'deleteEventImage'])->name('admin.event.image.delete');
        Route::post('event/speaker/delete', [EventController::class, 'deleteEventSpeaker'])->name('admin.event.speaker.delete');
        Route::post('event/tab/delete', [EventController::class, 'deleteEventTab'])->name('admin.event.tab.delete');
        Route::post('event/tab/button/delete', [EventController::class, 'deleteEventTabButton'])->name('admin.event.tab.button.delete');
        Route::get('event/status/update/{status}/{event_id}', [EventController::class, 'updateEventStatus'])->name('admin.event.status.update');
        // Route::get('event/workshops/edit/{slug}',[EventController::class,'editEventWorkshop'])->name('admin.event.workshop.edit');
        Route::post('event/workshops/update', [EventController::class, 'updateEventWorkshop'])->name('admin.event.workshop.update');
        // Route::post('event/workshops/program/edit',[EventController::class,'editEventWorkshopProgram'])->name('admin.event.workshop.program.edit');
        // Route::post('event/workshops/program/update',[EventController::class,'updateEventWorkshopProgram'])->name('admin.event.workshop.program.update');
        // Route::post('event/workshops/program/delete',[EventController::class,'deleteEventWorkshopProgram'])->name('admin.event.workshop.program.delete');
        // Route::post('event/workshop/delete',[EventController::class,'deleteEventWorkshopSection'])->name('admin.event.workshop.section.delete');


        // Event workshop management
        Route::get('manage/event/activities', [EventWorkshopController::class, 'manageWorkshop'])->name('admin.manage.event.workshops');
        Route::get('manage/event/workshops/create', [EventWorkshopController::class, 'createEventWorkshop'])->name('admin.event.workshop.create');
        Route::post('manage/event/workshops/store', [EventWorkshopController::class, 'storeEventWorkshop'])->name('admin.event.workshop.store');
        Route::get('manage/event/workshops/edit/{uuid}', [EventWorkshopController::class, 'editEventWorkshop'])->name('admin.event.workshop.edit');
        Route::post('manage/event/workshops/update', [EventWorkshopController::class, 'updateEventWorkshop'])->name('admin.event.workshop.update');
        Route::post('manage/event/workshops/status', [EventWorkshopController::class, 'updateStatusEventWorkshop'])->name('admin.event.workshop.status');
        Route::post('manage/event/workshops/program/delete', [EventWorkshopController::class, 'deleteEventWorkshopProgram'])->name('admin.event.workshop.program.delete');
        Route::post('manage/event/optional/delete', [EventWorkshopController::class, 'deleteEventOptional'])->name('admin.event.optional.delete');

        // Event Dashboard
        Route::get('manage/event/dashboard', [EventController::class, 'eventDashboard'])->name('admin.manage.event.dashboard');
        Route::get('manage/event-details/{uuid}/{type?}/{survey_uuid?}', [EventController::class, 'eventDetails'])->name('admin.event.details');
        Route::get('export-event-details', [EventController::class, 'exportEventDetails'])->name('admin.export.event.details');


        // Location management
        // Route::get('manage/country', [LocationController::class, 'manageCountries'])->name('admin.manage.countries');
        // Route::post('country/create', [LocationController::class, 'createCountry'])->name('admin.create.country');
        // Route::post('country/delete', [LocationController::class, 'deleteCountry'])->name('admin.country.delete');
        // Route::post('country/edit', [LocationController::class, 'editCountry'])->name('admin.country.edit');
        // Route::post('country/update', [LocationController::class, 'updateCountry'])->name('admin.update.country');

        // Membership management

        Route::post('membership/create', [MembershipController::class, 'createMemberShip'])->name('admin.create.membership');
        Route::get('membership/page/edit/{id}', [MembershipController::class, 'editMembership'])->name('admin.content.membership.edit');
        Route::post('membership/package/delete', [MembershipController::class, 'deleteMemberShipPackage'])->name('admin.membership-package.delete');
        Route::post('membership/update', [MembershipController::class, 'updateMembership'])->name('admin.update.membership');


        // Manage Default membership

        Route::get('default/membership/manage', [MembershipController::class, 'manageDefaultMembership'])->name('admin.default.membership.package');
        Route::post('default/membership/set', [MembershipController::class, 'setDefaultMembership'])->name('admin.set.default.membership.package');


        // Customer management
        // Route::get('manage/customers', [CustomerController::class, 'manageCustomers'])->name('admin.manage.customer');
        Route::post('upload/customers', [CustomerController::class, 'uploadCustomers'])->name('admin.customer.upload');
        Route::get('create/member', [CustomerController::class, 'createMember'])->name('admin.create.member');
        Route::post('store/member', [CustomerController::class, 'storeMember'])->name('admin.store.member');
        Route::get('member/dashboard', [CustomerController::class, 'memberDashboard'])->name('admin.member.dashboard');
        Route::get('edit/member/{id}', [CustomerController::class, 'editMember'])->name('admin.edit.member');
        Route::post('update/member', [CustomerController::class, 'updateMember'])->name('admin.update.member');
        Route::get('view/member/{id}/{type?}/{position_uuid?}/{member_id?}', [CustomerController::class, 'viewMember'])->name('admin.view.member');
        Route::post('resend-email', [CustomerController::class, 'resendEmail'])->name('admin.resend.email');


        // News management
        Route::get('manage/news', [NewsController::class, 'manageNews'])->name('admin.manage.news');
        Route::get('create/news', [NewsController::class, 'createNews'])->name('admin.create.news');
        Route::post('store/news', [NewsController::class, 'storeNews'])->name('admin.store.news');
        Route::get('edit/news/{uuid}', [NewsController::class, 'editNews'])->name('admin.edit.news');
        Route::delete('delete/news', [NewsController::class, 'deleteNews'])->name('admin.delete.news');
        Route::post('update/news', [NewsController::class, 'updateNews'])->name('admin.update.news');

        // Resources Management
        Route::post('resource/temp-card/create', [ResourceController::class, 'tempCardCreate'])->name('admin.resource.temp.card.create');
        Route::post('resource/temp-card/delete', [ResourceController::class, 'tempCardDelete'])->name('admin.resource.temp.card.delete');
        Route::get('resource/temp-card/edit', [ResourceController::class, 'tempCardEdit'])->name('admin.resource.temp.card.edit');
        Route::post('resource/temp-card/update', [ResourceController::class, 'tempCardUpdate'])->name('admin.resource.temp.card.update');
        Route::post('resource/store', [ResourceController::class, 'store'])->name('admin.resource.store');
        Route::get('resource/edit/{id}', [ResourceController::class, 'edit'])->name('admin.resource.edit');
        Route::post('resource/remove-section', [ResourceController::class, 'removeSection'])->name('admin.resource.remove.section');

        // Contact Us Management
        Route::post('contact-us/store', [ContactUsController::class, 'store'])->name('admin.contact.us.store');
        Route::get('contact-us/edit/{id}', [ContactUsController::class, 'edit'])->name('admin.contact.us.edit');
        /*----------- Nomination management------------*/

        // Membership Type

        Route::get('nomination/membership-type', [NominationController::class, 'membershipType'])->name('admin.nomination.membership.type');
        Route::post('nomination/membership-type/create', [NominationController::class, 'createUpdateMembershipType'])->name('admin.nomination.membership.type.create');
        Route::delete('nomination/membership-type/delete', [NominationController::class, 'deleteMembershipType'])->name('admin.nomination.membership.type.delete');
        Route::get('nomination/membership-type/edit/{uuid}', [NominationController::class, 'editMembershipType'])->name('admin.nomination.membership.type.edit');

        // Membership Position

        Route::get('nomination/membership-position', [NominationController::class, 'membershipPosition'])->name('admin.nomination.membership.position');
        Route::post('nomination/membership-position/create', [NominationController::class, 'createMembershipPosition'])->name('admin.nomination.membership.position.create');
        Route::delete('nomination/membership-position/delete', [NominationController::class, 'deleteMembershipPosition'])->name('admin.nomination.membership.position.delete');
        Route::get('nomination/membership-position/edit/{uuid}', [NominationController::class, 'editMembershipPosition'])->name('admin.nomination.membership.position.edit');

        // Nomination

        Route::get('nomination/create', [NominationController::class, 'createNomination'])->name('admin.nomination.create');
        Route::post('nomination/store', [NominationController::class, 'storeNomination'])->name('admin.nomination.store');
        Route::get('nomination/dashboard', [NominationController::class, 'dashboard'])->name('admin.nomination.dashboard');
        Route::get('nomination-position/details/{uuid}', [NominationController::class, 'nominationPositionDetails'])->name('admin.nomination.position.details');
        Route::post('nomination-position-reject', [NominationController::class, 'nominationPositionReject'])->name('admin.nomination.position.reject');
        Route::post('nomination-position-accept', [NominationController::class, 'nominationPositionAccept'])->name('admin.nomination.position.accept');
        Route::get('customer-nomination-list/{uuid}/{member_id}', [NominationController::class, 'customerNominationList'])->name('customer.nomination.list');
        Route::get('nomination-position-export', [NominationController::class, 'nominationPositionExport'])->name('nomination.position.export');
        Route::get('customer-nomination-export', [NominationController::class, 'customerNominationExport'])->name('customer.nomination.export');
        Route::get('nomination/content/manage', [NominationController::class, 'manageNominationContent'])->name('admin.nomination.content.manage');
        Route::post('nomination/content/create', [NominationController::class, 'nominationCreateContent'])->name('admin.nomination.create.content');

        // Survey Certificate
        Route::get('survey-certificate/dashboard', [EventSurveyCertificateController::class, 'dashboard'])->name('admin.survey.certificate.dashboard');
        Route::get('survey-certificate/view-survey/{uuid}', [EventSurveyCertificateController::class, 'viewSurvey'])->name('admin.survey.certificate.view');
        Route::get('survey-certificate/edit-survey/{uuid}', [EventSurveyCertificateController::class, 'editSurvey'])->name('admin.survey.certificate.edit');
        Route::post('survey-certificate/update-survey-form', [EventSurveyCertificateController::class, 'updateSurveyForm'])->name('admin.survey.certificate.update');
        Route::get('survey-certificate/export', [EventSurveyCertificateController::class, 'exportSurvey'])->name('admin.survey.certificate.export');
        Route::get('certificate-attributes', [EventSurveyCertificateController::class, 'certificateAttributes'])->name('admin.certificate.attributes');
        Route::post('certificate-attributes/create', [EventSurveyCertificateController::class, 'certificateAttributesCreate'])->name('admin.certificate.attributes.create');
        Route::get('certificate-sent/{survey_uuid}', [EventSurveyCertificateController::class, 'certificateSent'])->name('admin.survey.certificate.sent');
    });
});
Route::post('/ck-editor-file-upload', [CommonController::class, 'ckUpload'])->name('ck.upload');
Route::post('admin/file-upload-dropzone', [CommonController::class, 'fileUpload'])->name('drop-zone-file-upload');


require __DIR__ . '/customer.php';
require __DIR__ . '/election.php';
