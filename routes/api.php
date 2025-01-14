<?php

use App\Http\Controllers\Apis\Attorney\AttorneyAreaApisController;
use App\Http\Controllers\Apis\Attorney\AttorneyCasesApisController;
use App\Http\Controllers\Apis\Attorney\AttorneyDashboardApiController;
use App\Http\Controllers\Apis\Attorney\AttorneyProfileApisController;
use App\Http\Controllers\Apis\Attorney\AttorneyTransactionApisController;
use App\Http\Controllers\Apis\Attorney\CaseFeedApiController;
use App\Http\Controllers\Apis\Attorney\ContractApiController;
use App\Http\Controllers\Apis\Auth\ApiAuthController;
use App\Http\Controllers\Apis\Customer\ApplicationApisController;
use App\Http\Controllers\Apis\Customer\CasesApisController;
use App\Http\Controllers\Apis\Customer\DashboardApisController;
use App\Http\Controllers\Apis\Customer\HiredAttorniesApisController;
use App\Http\Controllers\Apis\Customer\MediaApisController;
use App\Http\Controllers\Apis\Customer\RestrictedAreaApisController;
use App\Http\Controllers\Apis\Customer\TransactionApisController;
use App\Http\Controllers\Apis\Marketing\LawsApisController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Customer\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//open apis
Route::post('auth/validate', [ApiAuthController::class, 'validateUser']);
Route::post('auth/register', [ApiAuthController::class, 'createUser']);
Route::post('auth/attorney/second-step-details', [ApiAuthController::class, 'createUserSecondStepAttorney']);
Route::post('auth/login', [ApiAuthController::class, 'loginUser']);
Route::post('auth/email-verification', [ApiAuthController::class, 'emailVerification']);
Route::post('auth/send-later-email-verification', [ApiAuthController::class, 'sendLaterVerificationCode']);

Route::post('password/reset', [ApiAuthController::class, 'sendResetLinkEmail']);

//marketing apis
Route::post('marketing/create-category', [LawsApisController::class, 'createCategory']);
Route::post('marketing/create-sub-category', [LawsApisController::class, 'createSubCategory']);
Route::post('marketing/search', [LawsApisController::class, 'search']);
Route::post('marketing/get-sub-categories-by-cat-id', [LawsApisController::class, 'searchDetail']);
Route::post('marketing/categories-limit', [LawsApisController::class, 'getCategoriesLimit']);
Route::get('marketing/all-categories', [LawsApisController::class, 'getAllCategories']);
Route::get('marketing/all-categories-with-subcategories', [LawsApisController::class, 'getAllCategoriesWithSubCategories']);
Route::get('marketing/all-lawyers', [LawsApisController::class, 'getAllLaywyers']);
Route::get('marketing/all-lawyers-page-data', [LawsApisController::class, 'getLaywyersData']);
Route::get('categories-subcategories-laywers', [RestrictedAreaApisController::class, 'getAllCategoriesWithSubCategoriesWithLawyers']);


//No Token Found Exception
Route::post('check-token', [ApiAuthController::class, 'checkToken'])->name('checkToken');
Route::get('noTokenFound', [ApiAuthController::class, 'noTokenFound'])->name('noTokenFound');


//authenticated apis
Route::middleware('auth:sanctum')->group(function () {

    Route::get('dashboard', [ApiAuthController::class, 'index']); //for testing of token
    Route::get('get-all-users', [ApiAuthController::class, 'getAllUsers']); //for testing of token

    //restricted area
    Route::post('update-profile', [RestrictedAreaApisController::class, 'updateProfile']);
    Route::post('case-media-upload-initial', [RestrictedAreaApisController::class, 'caseMediaUploadInitial']);
    Route::post('case-dynamic-intake-form', [RestrictedAreaApisController::class, 'getIntakeForms']);
    Route::post('case-details', [RestrictedAreaApisController::class, 'caseDetails']);
    Route::post('case-details-edit', [RestrictedAreaApisController::class, 'caseDetailsEdit']);
    Route::post('case-bid-and-user-payment-details', [RestrictedAreaApisController::class, 'caseBidAndUserPaymentDetails']);
    Route::post('case-get-plan', [RestrictedAreaApisController::class, 'getCasePaymentPlan']);
    Route::post('case-payment-plan-store', [RestrictedAreaApisController::class, 'casePaymentPlanStore']);
    Route::post('case-preview', [RestrictedAreaApisController::class, 'casePreview']);
    Route::post('case-submit', [RestrictedAreaApisController::class, 'caseSubmit']); //notification

    Route::post('get-all-attornies', [RestrictedAreaApisController::class, 'getAllAttornies']);
    Route::post('get-attorney-details', [RestrictedAreaApisController::class, 'getAttorneyDetails']);

    Route::post('get-contract-check', [RestrictedAreaApisController::class, 'getContractCheck']);
    Route::post('get-contract-details', [RestrictedAreaApisController::class, 'getContractDetails']);
    Route::post('customer-contract', [RestrictedAreaApisController::class, 'customerContract']); //notificaiton

    Route::post('schedule-appointment', [RestrictedAreaApisController::class, 'scheduleAppointment']); //notification
    Route::post('user-appointments', [RestrictedAreaApisController::class, 'getUsersAppointments']);

    //dashboard
    Route::post('search', [LawsApisController::class, 'search']);
    Route::post('view-profile', [DashboardApisController::class, 'viewProfile']);
    Route::post('update-password', [DashboardApisController::class, 'updatePassword']); //notification
    Route::post('delete-user', [ApiAuthController::class, 'deleteUser']);

    //contracts
    Route::post('get-customer-contract-list', [DashboardApisController::class, 'getCustomerContractList']);
    Route::post('get-customer-contract-detail', [DashboardApisController::class, 'getCustomerContractDetails']);

    //applications
    Route::post('add-application', [ApplicationApisController::class, 'addApplication']);
    Route::post('update-application', [ApplicationApisController::class, 'updateApplication']);
    Route::post('payment-plan-for-application', [ApplicationApisController::class, 'paymenPlanForApplication']);
    Route::post('applications', [ApplicationApisController::class, 'allApplications']);
    Route::post('application-submit', [ApplicationApisController::class, 'caseSubmitApplication']); //notification
    Route::post('view-application', [ApplicationApisController::class, 'viewApplication']);
    Route::post('delete-application', [ApplicationApisController::class, 'deleteApplication']);

    //cases
    Route::post('cases', [CasesApisController::class, 'allCases']);
    Route::post('view-case', [CasesApisController::class, 'viewCase']);
    Route::post('attorney-ratings', [CasesApisController::class, 'attorneyRatings']);
    Route::post('customer-feedback', [CasesApisController::class, 'customerFeedback']);
    Route::post('customer-get-feedback', [CasesApisController::class, 'customerGetFeedback']);
    Route::post('reject-contract-customer', [CasesApisController::class, 'rejectContractCustomer']);

    //Hired Attornies
    Route::post('hired-attornies', [HiredAttorniesApisController::class, 'allHiredAttornies']);
    Route::post('hired-attornies-details', [HiredAttorniesApisController::class, 'hiredAttorneyDetails']);

    //user-button area
    //case media
    Route::post('user-case-preview', [MediaApisController::class, 'casesPreview']);
    Route::post('case-media-preview', [MediaApisController::class, 'caseMediaPreview']);
    Route::post('get-cases', [MediaApisController::class, 'getCases']);
    Route::post('case-media-upload', [MediaApisController::class, 'caseMediaUpload']);
    Route::post('case-media-delete', [MediaApisController::class, 'caseMediaDelete']);
    //application form
    Route::post('get-applications', [DashboardApisController::class, 'getApplications']);
    //attornies
    Route::post('get-attornies', [DashboardApisController::class, 'getAssignedAttornies']);

    //transactions and invoices
    Route::post('get-all-invoices', [TransactionApisController::class, 'allInvoices']);
    Route::post('get-transactions', [TransactionApisController::class, 'invoicesTransactions']);




//Attorney APIs starts ------------------------------------------------------------------------------------------------------------- //

    //attorney restricted area
    Route::post('attorney/update-profile', [AttorneyAreaApisController::class, 'updateProfile']);

    Route::post('attorney/application-media-upload', [AttorneyAreaApisController::class, 'attorneyApplicationMediaUpload']);
    Route::post('attorney/application-details', [AttorneyAreaApisController::class, 'attorneyApplicationDetails']);
    Route::post('attorney/agreement', [AttorneyAreaApisController::class, 'attorneyAgreement']);
    Route::post('attorney/card-details', [AttorneyAreaApisController::class, 'storeCardDetails']); //notification
    Route::post('attorney/payment-details', [AttorneyAreaApisController::class, 'storePaymentDetails']); //notification
    Route::post('attorney/application-detail-preview', [AttorneyAreaApisController::class, 'applicationDetailPreview']);
    Route::post('attorney/application-detail-preview-submit', [AttorneyAreaApisController::class, 'applicationDetailPreviewSubmit']); //notification

    //terms and condition / fee intake for attorney
    Route::get('attorney/attorney-terms-and-conditions', [AttorneyAreaApisController::class, 'attorneyTermsAndConditions']);
    Route::get('attorney/universal-client-attorney-agreements', [AttorneyAreaApisController::class, 'attorneyUniversalClientAttorneyAgreements']);
    Route::post('attorney/attorney-fee-intake', [AttorneyAreaApisController::class, 'attorneyFeeIntake']);

    //automate api of attorney application
    Route::post('attorney/application-automate', [AttorneyAreaApisController::class, 'applicationAcceptAutomate']);

    //attorney case feed
    Route::post('attorney/case-feed-list', [CaseFeedApiController::class, 'caseFeed']);
    Route::post('attorney/case-feed-details', [CaseFeedApiController::class, 'caseFeedDetails']);
    Route::post('attorney/case-feed-attornies', [CaseFeedApiController::class, 'caseAttornies']);

    //contracts
    Route::post('attorney/new-contracts', [ContractApiController::class, 'getNewContracts']);
    Route::post('attorney/accepted-contracts', [ContractApiController::class, 'getAcceptedConracts']);
    Route::post('attorney/contract-details', [ContractApiController::class, 'getContractDetails']);
    Route::post('attorney/accept-contract', [ContractApiController::class, 'acceptContract']); //notification
    Route::post('attorney/reject-contract', [ContractApiController::class, 'rejectContract']); //notification

    //Faq
    Route::get('attorney/faqs', [AttorneyDashboardApiController::class, 'faqs']);

    //Appointments
    Route::post('attorney/schedule-appointment', [AttorneyDashboardApiController::class, 'scheduleAppointment']); //notification
    Route::post('attorney/all-customer-appointments', [AttorneyDashboardApiController::class, 'getAllCustomerAppointments']);
    Route::post('attorney/customer-appointments', [AttorneyDashboardApiController::class, 'getCustomerAppointments']);

    //Profile
    Route::post('attorney/update-password', [AttorneyProfileApisController::class, 'updatePassword']); //notification
    Route::post('attorney/get-attorney', [AttorneyProfileApisController::class, 'getAttorney']);
    Route::post('attorney/profile/update-profile', [AttorneyProfileApisController::class, 'updateProfile']);

    //search
    Route::post('attorney/search', [AttorneyDashboardApiController::class, 'search']);

    // cases
    Route::post('attorney/cases-counts', [AttorneyCasesApisController::class, 'getCasesCounts']);
    Route::post('attorney/list-cases', [AttorneyCasesApisController::class, 'listCases']);
    Route::post('attorney/detail-cases', [AttorneyCasesApisController::class, 'detailCases']);
    Route::post('attorney/end-cases', [AttorneyCasesApisController::class, 'endCase']);

    //transactions and invoices
    Route::post('attorney/get-all-invoices', [AttorneyTransactionApisController::class, 'allInvoices']);
    Route::post('attorney/get-transactions', [AttorneyTransactionApisController::class, 'invoicesTransactions']);
    Route::post('attorney/get-attorney-ybl-transaction-invoices', [AttorneyTransactionApisController::class, 'attorneyInvoicesFromYBL']);

    Route::post('attorney/manual-transaction', [AttorneyTransactionApisController::class, 'attorneyManualTransactionApply']);
    Route::post('attorney/update-stripe-connect-account-id', [AttorneyTransactionApisController::class, 'updateStripeConnectId']);
    Route::post('attorney/update-card-details', [AttorneyTransactionApisController::class, 'updateAttorneyCard']);

});

//-----------------------------------------------FOR CHAT------------------------------------------
    Route::post('/chat/pusher/auth', [ChatController::class, 'pusherAuth'])->name('chat_pusherAuth');

    Route::post('/chat/conversation-for-customer', [ChatController::class, 'conversationsForCustomer'])->name('chat_conversationForCustomer');
    Route::post('/chat/conversation-for-attorney', [ChatController::class, 'conversationsForAttorney'])->name('chat_conversationsForAttorney');
    Route::post('/chat/send-message', [ChatController::class, 'sendMessage'])->name('chat_sendMessage');
    Route::post('/chat/get-messages', [ChatController::class, 'getMessages'])->name('chat_getMessages');
    Route::post('/chat/chat-mark-as-read', [ChatController::class, 'chatMarkAsRead'])->name('chat_chatMarkAsRead');
    Route::post('/chat/mark-as-read/{sender?}/{receiver?}', [ChatController::class, 'markAsRead'])->name('chat_markAsRead');
