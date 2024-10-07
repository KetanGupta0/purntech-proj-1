<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use App\Http\Middleware\AdminAuthCheck;
use App\Http\Middleware\LoggedUserCheck;
use App\Http\Middleware\UserAuthCheck;
use App\Models\CompanyService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/enquiry');
});

// Test Routes needs to be removed
Route::get('/admin-dashboard-view', [AdminController::class, 'adminDashboardView']);
Route::get('/user-dashboard-view', [UserController::class, 'userDashboardView']);

// Global Logout For Admin and User
Route::get('/logout', [WebController::class, 'logout']);

// User Specific Routes
Route::middleware([UserAuthCheck::class])->group(function () {
    // View Routes
    Route::get('/user-dashboard', [UserController::class, 'userDashboardView']);
    Route::get('/user/profile', [UserController::class, 'profileView']);
    Route::get('/user/documents', [UserController::class, 'documentsView']);
    Route::get('/user/invoices', [UserController::class, 'invoicesView']);
    Route::get('/user/approval-letter', [UserController::class, 'appravalLetterView']);
    Route::get('/user/bank-details', [UserController::class, 'bankDetailsView']);
    Route::get('/user/payments', [UserController::class, 'paymentsView']);
    Route::get('/user/download', [UserController::class, 'downloadView']);
    Route::get('/user/help', [UserController::class, 'helpView']);

    // Normal Calls
    Route::post('/user-update-profile', [UserController::class, 'updateUserProfile']);
    Route::post('/upload-user-doc', [UserController::class, 'userDocsUpload']);
    Route::post('/save-bank-info', [UserController::class, 'saveUserBankData']);

    Route::post('/user/invoices/invoice-view', [UserController::class, 'viewUserInvoiceCommand']);
    Route::get('/user/view-approval-letter',[UserController::class,'viewApprovalLetter']);

    // AJAX Calls
    Route::get('/fetch-user-documents', [UserController::class, 'getUserDocsAJAX']);
});

// Admin Specific Routes
Route::middleware([AdminAuthCheck::class])->group(function () {
    // View Routes
    Route::get('/admin-dashboard', [AdminController::class, 'adminDashboardView']);
    Route::get('/admin/user-profiles', [AdminController::class, 'userProfileView']);
    Route::get('/admin/user-documents', [AdminController::class, 'userDocumentsView']);
    Route::get('/admin/user-kyc', [AdminController::class, 'userKYCView']);
    Route::get('/admin/user-bank-details', [AdminController::class, 'userBankDetailsView']);
    Route::get('/admin/user-invoices-page', [AdminController::class, 'userInvoicesPageView']);
    Route::get('/admin/reminders', [AdminController::class, 'remindersView']);
    Route::get('/admin/user-download', [AdminController::class, 'userDownloadView']);
    Route::get('/admin/reports', [AdminController::class, 'adminReportsView']);
    Route::get('/admin/profile', [AdminController::class, 'adminProfileView']);
    Route::get('/admin/settings', [AdminController::class, 'adminSettingsView']);
    Route::get('/admin/help', [AdminController::class, 'adminHelpView']);

    // Normal Calls
    Route::post('/admin/user-profiles/block-user', [AdminController::class, 'blockUserCommand']);
    Route::post('/admin/user-profiles/unblock-user', [AdminController::class, 'unblockUserCommand']);
    Route::post('/admin/user-profiles/view-user', [AdminController::class, 'viewUserCommand']);
    Route::post('/admin/user-profiles/edit-user', [AdminController::class, 'editUserCommand']);
    Route::post('/admin/user-profiles/delete-user', [AdminController::class, 'deleteUserCommand']);
    Route::post('/admin/user-profiles/user-update', [AdminController::class, 'userUpdateCommand']);
    Route::post('/admin/user-profiles/user-documents-update', [AdminController::class, 'userDocumentsUpdateCommand']);

    Route::post('/admin/user-documents/review-verified-documents', [AdminController::class, 'reviewVerifiedDocumentsCommand']);
    Route::post('/admin/user-documents/verify-documents', [AdminController::class, 'verifyDocumentsCommand']);
    Route::post('/admin/user-documents/verify-documents/verify-now', [AdminController::class, 'verifyNowDocumentCommand']);
    Route::post('/admin/user-documents/verify-documents/reject-now', [AdminController::class, 'rejectNowDocumentCommand']);
    Route::post('/admin/user-documents/verify-documents/delete-now', [AdminController::class, 'deleteNowDocumentCommand']);
    
    Route::post('/admin/user-bank-details/view-user-bank-details', [AdminController::class, 'viewUserBankDetailsCommand']);
    Route::post('/admin/user-bank-details/update-view-user-bank-details', [AdminController::class, 'updateViewUserBankDetailsCommand']);
    Route::post('/admin/user-bank-details/update-user-bank-details', [AdminController::class, 'updateUserBankDetailsCommand']);
    Route::post('/admin/user-bank-details/update-status', [AdminController::class, 'updateUserBankDetailsKYCCommand']);

    Route::post('/admin/user-invoices-page/raise-new-invoice',[AdminController::class, 'raiseNewInvoiceCommand']);
    Route::post('/admin/user-invoices-page/raise-new-invoice/form-submit',[AdminController::class, 'raiseNewInvoiceFormSubmitCommand']);

    Route::post('/admin/user-invoices-page/view-invoice-list',[AdminController::class, 'viewUserInvoiceList']);
    Route::post('/admin/user-invoices-page/command/paid',[AdminController::class, 'makeInvoicePaidCommand']);
    Route::post('/admin/user-invoices-page/command/pending',[AdminController::class, 'makeInvoicePendingCommand']);
    Route::post('/admin/user-invoices-page/command/partial',[AdminController::class, 'makeInvoicePartialPaidCommand']);
    Route::post('/admin/user-invoices-page/command/refunded',[AdminController::class, 'makeInvoiceRefundedCommand']);
    Route::post('/admin/user-invoices-page/command/unpaid',[AdminController::class, 'makeInvoiceUnpaidCommand']);
    Route::post('/admin/user-invoices-page/command/delete',[AdminController::class, 'makeInvoiceDeleteCommand']);
    Route::get('/admin/user-invoices-page/command/view/{id}/{inv_id}',[AdminController::class, 'invoiceViewCommand']);
    
    Route::post('admin/send-reminder',[AdminController::class, 'sendReminderCommand']);

    Route::post('/admin/user-download/upload-file',[AdminController::class, 'uploadFileCommand']);
    Route::post('/admin/user-download/hide-file',[AdminController::class, 'hideFileCommand']);
    Route::post('/admin/user-download/show-file',[AdminController::class, 'showFileCommand']);
    Route::post('/admin/user-download/delete-file',[AdminController::class, 'deleteFileCommand']);

    // Admin Setting Routs
    Route::post('/admin/settings/update-company',[AdminController::class, 'updateCompanyCommand']);
    Route::post('/admin/settings/update-company-bank',[AdminController::class, 'updateCompanyBankCommand']);
    Route::post('/admin/settings/update-approval-letter',[AdminController::class, 'updateApprovalLetterCommand']);
    Route::post('/admin/settings/update-invoice',[AdminController::class, 'updateInvoiceCommand']);
    Route::post('/admin/settings/admin-account',[AdminController::class, 'updateAdminAccountCommand']);

    Route::get('/admin/view/approval/{id}',[AdminController::class,'viewApprovalLetter']);

    
    // AJAX Calls
    

});

// Login Pages
Route::middleware([LoggedUserCheck::class])->group(function () {
    Route::get('/admin-login', [AdminController::class, 'adminLoginView']);
    Route::get('/user-login', [UserController::class, 'userLoginView']);
    // Enquiry Page
    Route::get('/enquiry', function () {
        $company = CompanyService::orderBy('cms_service_name','ASC')->get();
        return view('header') . view('User.enquiry',compact('company')) . view('footer');
    });
    Route::post('/admin-login-submit', [AdminController::class, 'adminLoginSubmit']);
});

// Normal Calls Global
Route::post('/enquiry-submit', [WebController::class, "enquiryFormSubmit"]);

// AJAX Calls Global
Route::post('/check-user-mobile', [WebController::class, 'verifyMobileAJAX']);
Route::post('/match-otp', [WebController::class, 'matchOTPAJAX']);
Route::get('/get-user-profile-picture', [WebController::class, 'getUserImageAJAX']);
Route::get('/get-admin-profile-picture', [WebController::class, 'getAdminImageAJAX']);
Route::get('fetch-company-info',[AdminController::class,'getCompanyInfo']);

// One time route
// Route::get('/make-admin', [AdminController::class, 'makeFirstAdmin']);