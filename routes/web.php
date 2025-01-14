<?php

use App\Http\Controllers\Admin\AdminApplicationController;
use App\Http\Controllers\Admin\AdminAttorniesController;
use App\Http\Controllers\Admin\AdminCasesController;
use App\Http\Controllers\Admin\AdminClientController;
use App\Http\Controllers\Admin\AdminContractController;
use App\Http\Controllers\Admin\AdminFaqsController;
use App\Http\Controllers\Admin\AdminInviteController;
use App\Http\Controllers\Admin\AdminMediaController;
use App\Http\Controllers\Admin\AdminPaymentTransactionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Attorney\AttorneyApplicationController;
use App\Http\Controllers\Attorney\AttorneyCasesController;
use App\Http\Controllers\Attorney\AttorneyChatController;
use App\Http\Controllers\Attorney\AttorneyContractController;
use App\Http\Controllers\Attorney\AttorneyFaqsController;
use App\Http\Controllers\Attorney\AttorneyInitials;
use App\Http\Controllers\Attorney\AttorneyInviteController;
use App\Http\Controllers\Attorney\AttorneyLeadsController;
use App\Http\Controllers\Attorney\AttorneyMediaController;
use App\Http\Controllers\Attorney\AttorneyPaymentTransactionController;
use App\Http\Controllers\Attorney\AttorneyProfileController;
use App\Http\Controllers\Attorney\AttorneyScheduleController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Attorney\DashboardController as AttorneyDashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\Customer\CustomerApplicationController;
use App\Http\Controllers\Customer\CustomerAttorniesController;
use App\Http\Controllers\Customer\CustomerCasesController;
use App\Http\Controllers\Customer\CustomerChatController;
use App\Http\Controllers\Customer\CustomerContractController;
use App\Http\Controllers\Customer\CustomerInitials;
use App\Http\Controllers\Customer\CustomerInviteController;
use App\Http\Controllers\Customer\CustomerMediaController;
use App\Http\Controllers\Customer\CustomerPaymentTransactionController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\CustomerScheduleController;
use App\Http\Controllers\Customer\CustomerVideoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketingController;
use App\Models\CustomerContract;
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

Auth::routes();

//check-password
Route::get('check-password', [HomeController::class, 'check_password'])->name('check_password');
Route::post('check-password-validate', [HomeController::class, 'check_password_validate'])->name('check_password_validate');

//front website un-authenticated user routes
// Route::middleware('check_password')->group(function () {

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('lawyers', [HomeController::class, 'lawyers'])->name('lawyers');
Route::get('case-types', [HomeController::class, 'customers'])->name('customers');
Route::post('search', [HomeController::class, 'homepage_search'])->name('homepage_search');

//test notification
Route::get('test-notification', [HomeController::class, 'testNotification'])->name('testNotificaiton');

// authentication routes
Route::get('auth', [LoginController::class, 'index'])->name('auth_index');
Route::get('auth/login', [LoginController::class, 'login_view'])->name('login_view');
Route::get('auth/register', [RegisterController::class, 'register_view'])->name('register_view');
Route::get('auth/verify-email', [RegisterController::class, 'verify_email'])->name('verify_email');
Route::get('auth/verify-now', [RegisterController::class, 'verify_now'])->name('verify_now');
Route::post('auth/verify-now-outside', [RegisterController::class, 'verify_email_outside'])->name('verify_email_outside');
Route::post('auth/verify-email-post', [RegisterController::class, 'verifyEmail'])->name('verifyEmail');
Route::post('auth/resend-code', [RegisterController::class, 'resendCode'])->name('resendCode');
Route::get('auth/verification', [RegisterController::class, 'verification'])->name('verification');
Route::get('auth/password-reset', [ForgotPasswordController::class, 'reset_view'])->name('reset_view');
Route::get('auth/password-reset-thankyou', [ForgotPasswordController::class, 'reset_thankyou_view'])->name('reset_thankyou_view');
Route::get('auth/password-reset-success', [ForgotPasswordController::class, 'password_success_view'])->name('password_success_view');

//marketing
Route::get('cases/{id}', [MarketingController::class, 'main_cases'])->name('marketing_main_cases');
Route::get('sub-categories/{id}', [MarketingController::class, 'child_cases'])->name('marketing_child_cases');

// });

//for app stripe onboarding views
Route::get('app-success', [HomeController::class, 'stripe_onboarding_app_success'])->name('stripe_onboarding_app_success');
Route::get('app-failed', [HomeController::class, 'stripe_onboarding_app_failed'])->name('stripe_onboarding_app_failed');

//cronjobs
Route::get('charge-customer-installments', [CronJobController::class, 'chargeCustomerInstallments'])->name('chargeCustomerInstallments');
Route::get('delete-case-application-after-48-hours', [CronJobController::class, 'deleteFirstCaseAfter48Hours'])->name('deleteFirstCaseAfter48Hours');
Route::get('delete-contract-after-48-hours', [CronJobController::class, 'deleteContractAfter48Hours'])->name('deleteContractAfter48Hours');

//contract terms and conditions
Route::get('terms-and-conditions/{cat_id}/{type}', [CustomerContractController::class, 'contract_terms_and_conditions'])->name('contract_terms_and_conditions');


// middleware routes
Route::middleware('admin')->prefix('admin')->group(function () {

    //dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin_dashboard');
    Route::post('search', [AdminDashboardController::class, 'search'])->name('admin_search');

    //attornies
    Route::get('attornies', [AdminAttorniesController::class, 'attornies'])->name('admin_attornies');
    Route::get('attornies-details/{attorney}', [AdminAttorniesController::class, 'attornies_details'])->name('admin_attornies_details');
    Route::post('application-assign', [AdminAttorniesController::class, 'assign_attornies'])->name('admin_assign_attornies');
    Route::post('attorney-review', [AdminAttorniesController::class, 'attorney_review'])->name('admin_attorney_review');
    Route::get('application-reject/{attorney}', [AdminAttorniesController::class, 'reject_attorney_application'])->name('admin_reject_attorney_application');

    //clients
    Route::get('clients', [AdminClientController::class, 'clients'])->name('admin_clients');
    Route::get('client-details/{customer?}', [AdminClientController::class, 'clients_details'])->name('admin_clients_details');

    //login status update for attorney and clients
    Route::post('update-status', [AdminDashboardController::class, 'update_status'])->name('admin_update_status');

    //applications
    Route::get('application', [AdminApplicationController::class, 'application'])->name('admin_application');
    Route::get('application-attornies/{filter}', [AdminApplicationController::class, 'application_attornies'])->name('admin_application_attornies');
    Route::get('application-customers/{filter}', [AdminApplicationController::class, 'application_customers'])->name('admin_application_customers');
    Route::get('application-customers-rejected/{application_id}', [AdminApplicationController::class, 'application_reject_customer'])->name('admin_application_reject_customer');
    Route::get('application-details/{application_id}', [AdminApplicationController::class, 'application_details'])->name('admin_application_details');
    Route::get('application-attorney-details/{application_id}', [AdminApplicationController::class, 'application_attorney_details'])->name('admin_application_attorney_details');

    //cases
    Route::get('cases', [AdminCasesController::class, 'cases'])->name('admin_cases');
    Route::get('all-cases/{filter}', [AdminCasesController::class, 'all_cases'])->name('admin_all_cases');
    Route::get('ongoing-cases', [AdminCasesController::class, 'ongoing_cases'])->name('admin_ongoing_cases');
    Route::get('cases-details/{case_id}', [AdminCasesController::class, 'case_details'])->name('admin_case_details');

    //media
    Route::get('media', [AdminMediaController::class, 'media'])->name('admin_media');

    //faqs
    Route::get('faqs', [AdminFaqsController::class, 'faqs'])->name('admin_faqs');

    //payment transactions
    Route::get('payment-transcations', [AdminPaymentTransactionController::class, 'payment_transactions'])->name('admin_payment_transactions');
    Route::get('transactions/{id}', [AdminPaymentTransactionController::class, 'transactions'])->name('admin_transactions');
    Route::get('attoenry-invoices', [AdminPaymentTransactionController::class, 'attorneyInvoices'])->name('admin_attorney_invoices');
    Route::post('ybl-fee-update', [AdminPaymentTransactionController::class, 'updateYblFee'])->name('admin_updateYblFee');

    //schedule
    Route::get('schedule', [AdminScheduleController::class, 'schedule'])->name('admin_schedule');

    //invite
    Route::get('invite', [AdminInviteController::class, 'invite'])->name('admin_invite');

    //contract
    Route::get('contract/{filter}', [AdminContractController::class, 'contract'])->name('admin_contract');
    Route::get('contract-details/{contract_id}', [AdminContractController::class, 'contracts_details'])->name('admin_contracts_details');

    //profile
    Route::get('profile', [AdminProfileController::class, 'profile'])->name('admin_profile');
    Route::get('edit-profile', [AdminProfileController::class, 'profile_edit'])->name('admin_profile_edit');
    Route::post('update-profile', [AdminProfileController::class, 'profile_update'])->name('admin_profile_update');

});

Route::middleware('customer')->prefix('customer')->group(function () {

    //for first interaction area starts
    Route::get('update-profile', [CustomerInitials::class, 'update_profile'])->name('customer_update_profile');
    Route::post('update-profile-store', [CustomerInitials::class, 'updateProfile'])->name('customer_update_profile_store');

    Route::get('get-law-sub-cats/{caseId?}', [CustomerInitials::class, 'get_law_sub_cats'])->name('customer_get_law_sub_cats');
    Route::get('get-packages/{caseSubCatId?}', [CustomerInitials::class, 'get_packages'])->name('customer_get_packages');
    Route::get('customer-application-form', [CustomerInitials::class, 'customer_application_form'])->name('customer_application_form');
    Route::post('customer-application-store', [CustomerInitials::class, 'customer_initial_intake_application_store_lego'])->name('customer_initial_intake_application_store_lego');
    // Route::post('customer-application-store', [CustomerInitials::class, 'customer_application_store'])->name('customer_application_store');

    Route::get('customer-payment-form', [CustomerInitials::class, 'customer_payment_bid_form'])->name('customer_payment_bid_form');
    Route::post('customer-card-store', [CustomerInitials::class, 'customer_card_store'])->name('customer_card_store');
    Route::post('customer-payment-store', [CustomerInitials::class, 'customer_payment_bid_store'])->name('customer_payment_bid_store');

    Route::get('customer-payment-plans', [CustomerInitials::class, 'customer_payment_plans'])->name('customer_payment_plans');
    Route::post('customer-payment-plans-store', [CustomerInitials::class, 'customer_payment_plans_store'])->name('customer_payment_plans_store');

    Route::get('customer-preview', [CustomerInitials::class, 'customer_preview'])->name('customer_preview');

    Route::post('customer-case-submit', [CustomerInitials::class, 'customer_case_submit'])->name('customer_case_submit');

    Route::get('customer-thankyou', [CustomerInitials::class, 'customer_thankyou'])->name('customer_thankyou');

    Route::get('attorney-bidding-list/{case_id}', [CustomerInitials::class, 'hired_attornies'])->name('customer_hired_attornies');
    Route::get('attorney-bidding-details/{attorney_id}', [CustomerInitials::class, 'hired_attornies_details'])->name('customer_hired_attornies_details');

    Route::get('customer-contract/{case_attorney_id}', [CustomerInitials::class, 'contracts'])->name('customer_contracts');
    Route::post('customer-contract-store', [CustomerInitials::class, 'customer_contracts_store'])->name('customer_contracts_store');

    Route::get('customer-contract-thank-you', [CustomerInitials::class, 'customer_contract_thank_you'])->name('customer_contract_thank_you');

    Route::get('initial-schedule', [CustomerInitials::class, 'schedule'])->name('customer_initial_schedule');

    Route::get('get-appointment-details', [CustomerInitials::class, 'get_appointment_details'])->name('customer_initial_get_appointment_details');
    Route::get('initial-schedule-appointment', [CustomerInitials::class, 'schedule_appointment'])->name('customer_initial_schedule_appointment');
    Route::post('customer-schedule-appointment-store', [CustomerInitials::class, 'customer_schedule_appointment_store'])->name('customer_schedule_appointment_store');

    Route::get('application-steps', [CustomerInitials::class, 'application_steps'])->name('customer_application_steps');

    //for first interaction area ends

    //dashboard
    Route::get('dashboard', [CustomerDashboardController::class, 'dashboard'])->name('customer_dashboard');
    Route::post('search', [CustomerDashboardController::class, 'search'])->name('customer_search');

    //applications
    Route::get('applications/{filter?}', [CustomerApplicationController::class, 'applications'])->name('customer_applications');
    Route::get('application-details/{application_id}', [CustomerApplicationController::class, 'detail_application'])->name('customer_detail_application');
    Route::get('application-delete/{id}', [CustomerApplicationController::class, 'customer_delete_application'])->name('customer_delete_application');

    Route::get('get-forms/{caseId?}', [CustomerApplicationController::class, 'dynamic_forms'])->name('customer_dynamic_forms');
    Route::post('add-application-store-lego', [CustomerApplicationController::class, 'customer_dashboard_intake_application_store_lego'])->name('customer_dashboard_intake_application_store_lego');

    Route::get('add-application', [CustomerApplicationController::class, 'add_application'])->name('customer_add_application');
    Route::post('add-application-store', [CustomerApplicationController::class, 'customer_dashboard_application_store'])->name('customer_dashboard_application_store');
    Route::get('add-application-step-2', [CustomerApplicationController::class, 'customer_dashboard_payment_bid_form'])->name('customer_dashboard_payment_bid_form');
    Route::post('add-application-step-2-store', [CustomerApplicationController::class, 'customer_dashboard_payment_bid_store'])->name('customer_dashboard_payment_bid_store');
    Route::get('add-application-step-3-payment', [CustomerApplicationController::class, 'customer_dashboard_payment_plans'])->name('customer_dashboard_payment_plan');
    Route::post('add-application-step-3-payment-store', [CustomerApplicationController::class, 'customer_dashboard_payment_plans_store'])->name('customer_dashboard_payment_plans_store');
    Route::get('add-application-step-3', [CustomerApplicationController::class, 'customer_dashboard_preview'])->name('customer_dashboard_preview');
    Route::post('add-application-step-3-store', [CustomerApplicationController::class, 'customer_dashboard_case_submit'])->name('customer_dashboard_case_submit');
    Route::get('add-application-step-4', [CustomerApplicationController::class, 'customer_dashboard_thankyou'])->name('customer_dashboard_thankyou');



    Route::get('application-initial-process', [CustomerApplicationController::class, 'application_initial_process'])->name('application_initial_process');

    //cases
    Route::get('cases/{status?}', [CustomerCasesController::class, 'cases'])->name('customer_cases');
    Route::get('cases-details/{case_id}', [CustomerCasesController::class, 'case_details'])->name('customer_case_details');
    Route::get('cases-reject/{id}', [CustomerCasesController::class, 'customer_case_reject'])->name('customer_case_reject');
    Route::get('case-end/{id}', [CustomerCasesController::class, 'attorney_review'])->name('customer_attorney_review');
    Route::post('case-review-store', [CustomerCasesController::class, 'customerReview'])->name('customer_customerReview');

    //attornies
    Route::get('attornies', [CustomerAttorniesController::class, 'attornies'])->name('customer_attornies');
    Route::get('attornies-detail/{id}', [CustomerAttorniesController::class, 'attornies_details'])->name('customer_attornies_details');

    //messages
    Route::get('chat', [CustomerChatController::class, 'chat_list'])->name('customer_chat_list');
    Route::get('messages/{receiver_id}', [CustomerChatController::class, 'messages'])->name('customer_messages');

    //media
    Route::get('media', [CustomerMediaController::class, 'media'])->name('customer_media');

    //videos
    Route::get('videos', [CustomerVideoController::class, 'videos'])->name('customer_videos');
    Route::get('video-details', [CustomerVideoController::class, 'video_details'])->name('customer_video_details');

    //payment transactions
    Route::get('payment-transactions', [CustomerPaymentTransactionController::class, 'payment_transactions'])->name('customer_payment_transactions');
    Route::get('transactions/{id}', [CustomerPaymentTransactionController::class, 'transactions'])->name('customer_transactions');
    Route::get('payment-transactions-add', [CustomerPaymentTransactionController::class, 'payment_transactions_add'])->name('customer_payment_transactions_add');

    //schedule
    Route::get('schedule', [CustomerScheduleController::class, 'customer_dashboard_schedule'])->name('customer_schedule');
    Route::get('schedule-appointment', [CustomerScheduleController::class, 'customer_dashboard_schedule_appointment'])->name('customer_schedule_appointment');
    Route::post('schedule-appointment-store', [CustomerScheduleController::class, 'customer_dashboard_schedule_appointment_store'])->name('customer_dashboard_schedule_appointment_store');

    //invite
    Route::get('invite', [CustomerInviteController::class, 'invite'])->name('customer_invite');
    Route::get('invite-received', [CustomerInviteController::class, 'invite_received'])->name('customer_invite_received');
    Route::get('invite-sent', [CustomerInviteController::class, 'invite_sent'])->name('customer_invite_sent');
    Route::get('invite-send', [CustomerInviteController::class, 'invite_send'])->name('customer_invite_send');

    //contract
    Route::get('contract', [CustomerContractController::class, 'contract'])->name('customer_contract');
    Route::get('contract-details/{contract_id}', [CustomerContractController::class, 'customer_get_contract_details'])->name('customer_get_contract_details');
    Route::get('contract-add/{case_id}/{attorney_id}', [CustomerContractController::class, 'customer_contract_add'])->name('customer_contract_add');
    Route::post('contract-dashboard-store', [CustomerContractController::class, 'customer_dashboard_contracts_store'])->name('customer_dashboard_contracts_store');
    Route::get('contract-cancel/{contract_id}', [CustomerContractController::class, 'customer_cancel_contract'])->name('customer_cancel_contract');


    //profle
    Route::get('profile', [CustomerProfileController::class, 'profile'])->name('customer_profile');
    Route::get('edit-profile', [CustomerProfileController::class, 'profile_edit'])->name('customer_profile_edit');
    Route::post('update-profile', [CustomerProfileController::class, 'profile_update'])->name('customer_profile_update');
    Route::get('update-card', [CustomerProfileController::class, 'update_card_details'])->name('customer_update_card_details');
    Route::post('update-card-store', [CustomerProfileController::class, 'update_card_details_store'])->name('customer_update_card_details_store');

});

Route::middleware('attorney')->prefix('attorney')->group(function () {

    //for first interaction area starts
    Route::get('update-profile', [AttorneyInitials::class, 'update_profile'])->name('attorney_update_profile');
    Route::post('update-profile-form', [AttorneyInitials::class, 'updateProfile'])->name('attorney_update_profile_form');

    Route::get('initial-application-form', [AttorneyInitials::class, 'initial_application_form'])->name('attorney_initial_application_form');

    Route::get('attorney-application-form', [AttorneyInitials::class, 'attorney_application_form'])->name('attorney_application_form');
    Route::post('attorney-application-form-store', [AttorneyInitials::class, 'attorney_application_form_store'])->name('attorney_application_form_store');

    Route::get('universal-client-attorney-agreements/{law_cat_id?}', [AttorneyInitials::class, 'attorney_universal_client_attorney_agreements'])->name('attorney_universal_client_attorney_agreements');
    Route::get('attorney-terms-and-conditions', [AttorneyInitials::class, 'attorney_terms_and_conditions'])->name('attorney_terms_and_conditions');
    Route::get('attorney-fee-intake/{law_cat_id?}', [AttorneyInitials::class, 'attorney_fee_intake'])->name('attorney_fee_intake');

    Route::get('attorney-agreement-form', [AttorneyInitials::class, 'attorney_agreement_form'])->name('attorney_agreement_form');
    Route::post('attorney-agreement-form-store', [AttorneyInitials::class, 'attorney_agreement_form_store'])->name('attorney_agreement_form_store');

    Route::get('attorney-payment-form', [AttorneyInitials::class, 'attorney_payment_form'])->name('attorney_payment_form');
    Route::post('attorney-card-store', [AttorneyInitials::class, 'attorney_card_store'])->name('attorney_card_store');
    Route::post('attorney-payment-form-store', [AttorneyInitials::class, 'attorney_payment_form_store'])->name('attorney_payment_form_store');
    Route::get('attorney-redirection', [AttorneyInitials::class, 'validate_attorney_connect_account'])->name('validate_attorney_connect_account');

    Route::get('attorney-application-preview', [AttorneyInitials::class, 'attorney_application_preview'])->name('attorney_application_preview');
    Route::post('attorney-application-preview-store', [AttorneyInitials::class, 'attorney_application_preview_store'])->name('attorney_application_preview_store');

    Route::get('attorney-application-processing-thankyou', [AttorneyInitials::class, 'attorney_application_processing_thankyou'])->name('attorney_application_processing_thankyou');
    Route::get('attorney-application-automate', [AttorneyInitials::class, 'attorney_application_automate'])->name('attorney_application_automate');

    Route::get('attorney-submit-new-application', [AttorneyInitials::class, 'submit_new_application'])->name('submit_new_application');


    //for first interaction area ends

    //dashboard
    Route::get('dashboard', [AttorneyDashboardController::class, 'dashboard'])->name('attorney_dashboard');
    Route::post('search', [AttorneyDashboardController::class, 'search'])->name('attorney_search');

    //applications
    Route::get('applications', [AttorneyApplicationController::class, 'application'])->name('attorney_applications');
    Route::get('add-application', [AttorneyApplicationController::class, 'add_application'])->name('attorney_add_application');
    Route::get('application-initial-process', [AttorneyApplicationController::class, 'application_initial_process'])->name('attorney_application_initial_process');

    //leads
    Route::get('leads', [AttorneyLeadsController::class, 'leads'])->name('attorney_leads');
    Route::get('leads-customer-details/{case_id}', [AttorneyLeadsController::class, 'leads_customer_details'])->name('attorney_leads_customer_details');
    Route::post('leads-interested', [AttorneyLeadsController::class, 'leads_interested'])->name('attorney_leads_interested');
    Route::post('leads-notinterested', [AttorneyLeadsController::class, 'leads_not_interested'])->name('attorney_leads_not_interested');

    //messages
    Route::get('chat', [AttorneyChatController::class, 'chat_list'])->name('attorney_chat_list');
    Route::get('messages/{receiver_id}', [AttorneyChatController::class, 'messages'])->name('attorney_messages');

    //cases
    Route::get('cases', [AttorneyCasesController::class, 'cases'])->name('attorney_cases');
    Route::get('all-cases/{filter}', [AttorneyCasesController::class, 'all_cases'])->name('attorney_all_cases');
    Route::get('ongoing-cases', [AttorneyCasesController::class, 'ongoing_cases'])->name('attorney_ongoing_cases');
    Route::get('cases-details/{case_id}', [AttorneyCasesController::class, 'case_details'])->name('attorney_case_details');
    Route::get('end-case/{case_id}/{attorney_id}', [AttorneyCasesController::class, 'end_case_by_attorney'])->name('attorney_end_case_by_attorney');

    //media
    Route::get('media', [AttorneyMediaController::class, 'media'])->name('attorney_media');

    //faqs
    Route::get('faqs', [AttorneyFaqsController::class, 'faqs'])->name('attorney_faqs');

    //payment transactions
    Route::get('payment-transactions', [AttorneyPaymentTransactionController::class, 'payment_transactions'])->name('attorney_payment_transactions');
    Route::get('transactions/{id}', [AttorneyPaymentTransactionController::class, 'transactions'])->name('attorney_transactions');
    Route::get('manual-charge/{payment_plan_id}/{transaction_id}', [AttorneyPaymentTransactionController::class, 'attorneyManualTransactionApply'])->name('attorney_attorneyManualTransactionApply');
    Route::get('payment-transactions-add', [AttorneyPaymentTransactionController::class, 'payment_transactions_add'])->name('attorney_payment_transactions_add');
    Route::get('my-ybl-invoices', [AttorneyPaymentTransactionController::class, 'attorneyInvoices'])->name('attorney_attorneyInvoices');

    //schedule
    Route::get('schedule', [AttorneyScheduleController::class, 'schedule'])->name('attorney_schedule');
    Route::get('schedule-appointment', [AttorneyScheduleController::class, 'schedule_appointment'])->name('attorney_schedule_appointment');
    Route::post('schedule-appointment-store', [AttorneyScheduleController::class, 'attorney_dashboard_schedule_appointment_store'])->name('attorney_dashboard_schedule_appointment_store');
    Route::get('schedule-get-appointment-details', [AttorneyScheduleController::class, 'attorney_get_appointment_details'])->name('attorney_get_appointment_details');

    //invite
    Route::get('invite', [AttorneyInviteController::class, 'invite'])->name('attorney_invite');
    Route::get('invite-received', [AttorneyInviteController::class, 'invite_received'])->name('attorney_invite_received');
    Route::get('invite-sent', [AttorneyInviteController::class, 'invite_sent'])->name('attorney_invite_sent');
    Route::get('invite-send', [AttorneyInviteController::class, 'invite_send'])->name('attorney_invite_send');

    //contract
    Route::get('contract-accepted', [AttorneyContractController::class, 'contract_accepted'])->name('attorney_contract_accepted');
    Route::get('contract-new', [AttorneyContractController::class, 'contract_new'])->name('attorney_contract_new');
    Route::get('contract-details/{contract_id}', [AttorneyContractController::class, 'contracts_details'])->name('attorney_contracts_details');
    Route::post('contract-accept', [AttorneyContractController::class, 'attorney_accept_contract'])->name('attorney_accept_contract');
    Route::get('contract', [AttorneyContractController::class, 'contract'])->name('attorney_contract');
    Route::get('contract-cancel-attorney/{contract_id}', [AttorneyContractController::class, 'attorney_cancel_contract'])->name('attorney_cancel_contract');

    //profle
    Route::get('profile', [AttorneyProfileController::class, 'profile'])->name('attorney_profile');
    Route::get('edit-profile', [AttorneyProfileController::class, 'profile_edit'])->name('attorney_profile_edit');
    Route::get('change-connect-id', [AttorneyProfileController::class, 'change_connect_id'])->name('attorney_change_connect_id');
    Route::get('attorney-validate', [AttorneyProfileController::class, 'validate_attorney_connect_account_via_dashboard'])->name('attorney_validate_attorney_connect_account_via_dashboard');
    Route::post('update-profile', [AttorneyProfileController::class, 'profile_update'])->name('attorney_profile_update');
    Route::get('update-card', [AttorneyProfileController::class, 'update_card_details'])->name('attorney_update_card_details');
    Route::post('update-card-store', [AttorneyProfileController::class, 'update_card_details_store'])->name('attorney_update_card_details_store');

});
