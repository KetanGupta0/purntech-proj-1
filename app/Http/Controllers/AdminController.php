<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Location;
use App\Models\ApprovalLetterSetting;
use App\Models\BankList;
use App\Models\CompanyBankDetail;
use App\Models\CompanyInfo;
use App\Models\Downloadable;
use App\Models\Invoice;
use App\Models\InvoiceDescriptionAmount;
use App\Models\CompanyService;
use App\Models\InvoiceSetting;
use App\Models\UserBankDetail;
use App\Models\UserDocuments;
use App\Models\UserInsurance;
use App\Models\UserTransaction;
use App\Models\WebUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function adminLoginView()
    {
        return view('header') . view('Admin.login') . view('footer');
    }

    public function adminDashboardView()
    {
        $company = CompanyInfo::find(1);
        if ($company) {
            return view('Admin.header') . view('Admin.dashboard', compact('company')) . view('Admin.footer');
        }
        else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    public function userProfileView()
    {
        $data = WebUser::where('usr_profile_status', '!=', 0)->orderBy('created_at', 'DESC')->get();
        return view('Admin.header') . view('Admin.user_profiles', compact('data')) . view('Admin.footer');
    }
    public function userDocumentsView()
    {
        try {
            $results = DB::table('web_users')
                ->leftJoin('user_documents', 'web_users.usr_id', '=', 'user_documents.udc_user_id')
                ->select(
                    'web_users.usr_id',
                    'web_users.usr_first_name',
                    'web_users.usr_last_name',
                    'web_users.usr_email',
                    'web_users.usr_mobile',
                    'user_documents.*'
                )
                ->where('web_users.usr_profile_status', '!=', 0)
                ->orderBy('web_users.created_at', 'DESC')
                ->get();

            // Group by user and create a new collection
            $groupedResults = $results->groupBy(function ($item) {
                return $item->usr_first_name . ' ' . $item->usr_last_name;
            });

            // Map to ensure user details are available and handle documents separately
            $data = $groupedResults->map(function ($items) {
                $userDetails = $items->first(); // Take user details from the first row (from web_users table)
                $documents = $items->filter(function ($item) {
                    return !is_null($item->udc_id); // Only include valid documents
                });
                return [
                    'user' => $userDetails,
                    'documents' => $documents
                ];
            });
            // dd($data);
            return view('Admin.header') . view('Admin.user_documents', compact('data')) . view('Admin.footer');
        } catch (Exception $e) {
            echo $e->getMessage();
            // return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userKYCView()
    {
        return view('Admin.header') . view('Admin.user_kyc') . view('Admin.footer');
    }
    public function userBankDetailsView()
    {
        try {
            $results = DB::table('web_users')
                ->leftJoin('user_bank_details', 'web_users.usr_id', '=', 'user_bank_details.ubd_usr_id')
                ->select(
                    'web_users.usr_id',
                    'web_users.usr_first_name',
                    'web_users.usr_last_name',
                    'web_users.usr_email',
                    'web_users.usr_mobile',
                    'user_bank_details.*'
                )
                ->where('web_users.usr_profile_status', '!=', 0)
                ->orderBy('web_users.created_at', 'DESC')
                ->get();
            // dd($results);
            return view('Admin.header') . view('Admin.user_bank_details', compact('results')) . view('Admin.footer');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function userInvoicesPageView()
    {
        $data = WebUser::where('usr_profile_status', '!=', 0)->orderBy('created_at', 'DESC')->get();
        return view('Admin.header') . view('Admin.user_invoices_page', compact('data')) . view('Admin.footer');
    }
    public function userInsurancePageView()
    {
        $data = WebUser::where('usr_profile_status', '!=', 0)->orderBy('created_at', 'DESC')->get();
        $insurance = UserInsurance::where('uin_status','=',1)->latest()->get();
        return view('Admin.header') . view('Admin.user_insurance', compact('data','insurance')) . view('Admin.footer');
    }
    public function userDownloadView()
    {
        $downloadables = Downloadable::where('dwn_status', '!=', 0)->get();
        return view('Admin.header') . view('Admin.user_download_page', compact('downloadables')) . view('Admin.footer');
    }
    public function adminReportsView()
    {
        $userTransactions = UserTransaction::where('tnx_status','=',1)->latest()->get();
        $users = WebUser::where('usr_profile_status','!=',0)->get();
        return view('Admin.header') . view('Admin.reports',compact('users','userTransactions')) . view('Admin.footer');
    }
    public function remindersView()
    {
        return view('Admin.header') . view('Admin.reminders') . view('Admin.footer');
    }
    public function adminProfileView()
    {
        return view('Admin.header') . view('Admin.admin_profile') . view('Admin.footer');
    }
    public function adminSettingsView()
    {
        try 
        {
            $companyInfo = CompanyInfo::where('cmp_id', '=', 1)->where('cmp_status', '=', 1)->first();
            $companyBankInfo = CompanyBankDetail::find(1);
            $banks = BankList::orderBy('bnk_name','ASC')->get();
            $approvalInfo = ApprovalLetterSetting::where('als_id', '=', 1)->where('als_status', '=', 1)->first();
            $invoiceInfo = InvoiceSetting::where('ins_id', '=', 1)->where('ins_status', '=', 1)->first();
            $admin = Admin::find(Session::get('uid'));
            return view('Admin.header') . view('Admin.admin_settings', compact('companyInfo','companyBankInfo', 'banks', 'approvalInfo', 'invoiceInfo', 'admin')) . view('Admin.footer');
        } catch (Exception $e) {
            return redirect()->to('/')->with('error', $e->getMessage());
        }
    }

    public function adminHelpView()
    {
        return view('Admin.header') . view('Admin.admin_help') . view('Admin.footer');
    }

    public function adminLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email is required!',
            'email.email' => 'Please enter a valid email!',
            'password.required' => 'Password is required!'
        ]);
        try {
            $admin = Admin::where('adm_email', $request->email)->where('adm_status', '!=', 0)->first();
            if ($admin && Hash::check($request->password, $admin->adm_password)) {
                Session::put('loggedin', 'admin');
                Session::put('uid', $admin->adm_id);
                Session::put('fusername', $admin->adm_first_name);
                Session::put('lusername', $admin->adm_last_name);
                Session::flash('welcome', "Welcome {$admin->adm_first_name} {$admin->adm_last_name}");
                return redirect('admin-dashboard');
            }
            else {
                return redirect()->back()->with('error', 'Incorrect email or password!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function blockUserCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $user->usr_profile_status = 2;
            if ($user->save()) {
                return redirect()->back()->with('success', 'User blocked successfully!');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong! Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function unblockUserCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $user->usr_profile_status = 1;
            if ($user->save()) {
                return redirect()->back()->with('success', 'User unblocked successfully!');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong! Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteUserCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $user->usr_profile_status = 0;
            if ($user->save()) {
                return redirect()->back()->with('success', 'User deleted successfully!');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong! Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function userUpdateCommand(Request $request)
    {
        // Validation Required
        try {
            if ($request->uid == "" || $request->uid == null) {
                return redirect('/')->with('error', 'Soemthing went wrong!');
            }
            else {
                $usr_first_name = $request->usr_first_name; // Required, String
                $usr_last_name = $request->usr_last_name; // Required, String
                $usr_email = $request->usr_email; // Required, String, Email
                $usr_mobile = $request->usr_mobile; // Required, Numeric, 10 digits
                $usr_alt_mobile = $request->usr_alt_mobile; // Not Required but if provided should be numeric and 10 digits
                $usr_dob = $request->usr_dob; // Required, string
                $usr_gender = $request->usr_gender;
                $usr_father = $request->usr_father;
                $usr_mother = $request->usr_mother;
                $usr_full_address = $request->usr_full_address; // Required, String
                $usr_landmark = $request->usr_landmark;
                $usr_service = $request->usr_service;
                $usr_adv_amount = $request->usr_adv_amount;
                $usr_mon_rent = $request->usr_mon_rent;
                $usr_adv_txnid = $request->usr_adv_txnid;
                $usr_adv_status = $request->usr_adv_status;


                $errors = [];

                // Validate first name (required, string)
                if (empty($usr_first_name)) {
                    $errors['usr_first_name'] = "First name is required.";
                }
                elseif (!is_string($usr_first_name)) {
                    $errors['usr_first_name'] = "First name must be a string.";
                }

                // Validate last name (required, string)
                if (empty($usr_last_name)) {
                    $errors['usr_last_name'] = "Last name is required.";
                }
                elseif (!is_string($usr_last_name)) {
                    $errors['usr_last_name'] = "Last name must be a string.";
                }

                // Validate email (required, valid email)
                if (empty($usr_email)) {
                    $errors['usr_email'] = "Email is required.";
                }
                elseif (!filter_var($usr_email, FILTER_VALIDATE_EMAIL)) {
                    $errors['usr_email'] = "Invalid email format.";
                }

                // Validate mobile number (required, numeric, 10 digits)
                if (empty($usr_mobile)) {
                    $errors['usr_mobile'] = "Mobile number is required.";
                }
                elseif (!is_numeric($usr_mobile) || strlen($usr_mobile) != 10) {
                    $errors['usr_mobile'] = "Mobile number must be numeric and exactly 10 digits.";
                }

                // Validate alternate mobile (optional, if provided, numeric, 10 digits)
                if (!empty($usr_alt_mobile)) {
                    if (!is_numeric($usr_alt_mobile) || strlen($usr_alt_mobile) != 10) {
                        $errors['usr_alt_mobile'] = "Alternate mobile number must be numeric and exactly 10 digits.";
                    }
                }

                // Validate date of birth (required)
                if (empty($usr_dob)) {
                    $errors['usr_dob'] = "Date of birth is required.";
                }

                // Validate gender (optional)
                $valid_genders = ['Male', 'Female', 'Other'];
                if (!empty($usr_gender) && !in_array($usr_gender, $valid_genders)) {
                    $errors['usr_gender'] = "Invalid gender selected.";
                }

                // Validate father's name (optional, string)
                if (!empty($usr_father) && !is_string($usr_father)) {
                    $errors['usr_father'] = "Father's name must be a string.";
                }

                // Validate mother's name (optional, string)
                if (!empty($usr_mother) && !is_string($usr_mother)) {
                    $errors['usr_mother'] = "Mother's name must be a string.";
                }

                // Validate full address (required, string)
                if (empty($usr_full_address)) {
                    $errors['usr_full_address'] = "Full address is required.";
                }
                elseif (!is_string($usr_full_address)) {
                    $errors['usr_full_address'] = "Full address must be a string.";
                }

                // Validate landmark (optional, string)
                if (!empty($usr_landmark) && !is_string($usr_landmark)) {
                    $errors['usr_landmark'] = "Landmark must be a string.";
                }

                // Validate service (optional, string)
                if (!empty($usr_service) && !is_string($usr_service)) {
                    $errors['usr_service'] = "Service must be a string.";
                }

                // Validate advance amount (optional, numeric)
                if (!empty($usr_adv_amount) && !is_numeric($usr_adv_amount)) {
                    $errors['usr_adv_amount'] = "Advance amount must be numeric.";
                }

                // Validate monthly rent (optional, numeric)
                if (!empty($usr_mon_rent) && !is_numeric($usr_mon_rent)) {
                    $errors['usr_mon_rent'] = "Monthly rent must be numeric.";
                }

                // Validate advance transaction ID (optional, string)
                if (!empty($usr_adv_txnid) && !is_string($usr_adv_txnid)) {
                    $errors['usr_adv_txnid'] = "Advance transaction ID must be a string.";
                }

                // Validate advance status (optional, string)
                if (!empty($usr_adv_status) && !is_string($usr_adv_status)) {
                    $errors['usr_adv_status'] = "Advance status must be a string.";
                }

                $outError = "";
                // Check if there are any errors
                if (count($errors) > 0) {
                    // Handle errors (e.g., display to the user)
                    foreach ($errors as $field => $error) {
                        $outError .= "$error ";
                    }
                    return view('Admin.gotouserViewPage', ['uid' => $request->uid, 'code' => 400, 'msg' => $outError]);
                }

                // dd(date('Y-m-d', strtotime($request->usr_dob)));

                $user = WebUser::find($request->uid);
                if ($user) {
                    $oldlocation = Location::where('loc_user_id','=',$request->uid)->where('loc_status','=',1)->first();
                    if($oldlocation) {
                        $oldlocation->loc_latitude = $request->latitude;
                        $oldlocation->loc_longitude = $request->longitude;
                        $oldlocation->save();
                    }else{
                        $location = new Location();
                        $location->loc_user_id = $request->uid;
                        $location->loc_latitude = $request->latitude;
                        $location->loc_longitude = $request->longitude;
                        $location->loc_status = 1;
                        $location->save();
                    }
                    $oldTnxId = $user->usr_adv_txnid;
                    $user->usr_first_name = $request->usr_first_name;
                    $user->usr_last_name = $request->usr_last_name;
                    $user->usr_email = $request->usr_email;
                    $user->usr_mobile = $request->usr_mobile;
                    $user->usr_alt_mobile = $request->usr_alt_mobile;
                    $user->usr_dob = date('Y-m-d', strtotime($request->usr_dob));
                    $user->usr_gender = $request->usr_gender;
                    $user->usr_father = $request->usr_father;
                    $user->usr_mother = $request->usr_mother;
                    $user->usr_full_address = $request->usr_full_address;
                    $user->usr_landmark = $request->usr_landmark;
                    $user->usr_service = $request->usr_service;
                    $user->usr_adv_amount = $request->usr_adv_amount;
                    $user->usr_mon_rent = $request->usr_mon_rent;
                    $user->usr_adv_txnid = $request->usr_adv_txnid;
                    $user->usr_adv_status = $request->usr_adv_status;
                    if ($user->save()) {
                        if ($request->usr_adv_txnid != '' && ($oldTnxId == "" || $oldTnxId == null)) {

                            $optMessage = "Dear " . $user->usr_first_name . ", Your " . 'file ' . $user->usr_username . " payment amount INR " . $user->usr_adv_amount . " sent successfully sent , Please note it will take up to 24 working hours to reflect amount in your bank account. FLNOTI";
                            $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162696221494512');

                        }
                        return view('Admin.gotouserViewPage', ['uid' => $user->usr_id, 'code' => 200, 'msg' => 'Profile data updated!']);
                    }
                    else {
                        return view('Admin.gotouserViewPage', ['uid' => $user->usr_id, 'code' => 400, 'msg' => 'Something went worng!']);
                    }
                }
                else {
                    return redirect()->to('/')->with('error', 'Something went wrong!');
                }
            }
        } catch (Exception $e) {
            return view('Admin.gotouserViewPage', ['uid' => $user->usr_id, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    /**
     * Validate a file manually for type, size, etc.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  string $fieldName
     * @throws Exception
     */
    private function validateFile($file, $fieldName)
    {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxFileSize = 2048; // 2MB

        // Check file size
        if ($file->getSize() > $maxFileSize * 1024) {
            throw new Exception("The file for {$fieldName} is too large. Maximum allowed size is {$maxFileSize}KB.");
        }

        // Check file mime type
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            throw new Exception("The file for {$fieldName} must be a JPG, PNG, or PDF.");
        }
    }
    public function userDocumentsUpdateCommand(Request $request)
    {
        try {
            $user = WebUser::find($request->uid);
            if($user){
                $fileFound = false;
                if ($request->hasFile('aadharf')) {
                    $file = $request->file('aadharf');
                    $this->validateFile($file, 'Aadhar Card Front');
                    $fileFound = true;
                }
                if ($request->hasFile('aadharb')) {
                    $file = $request->file('aadharb');
                    $this->validateFile($file, 'Aadhar Card Back');
                    $fileFound = true;
                }
                if ($request->hasFile('pancard')) {
                    $file = $request->file('pancard');
                    $this->validateFile($file, 'PAN Card');
                    $fileFound = true;
                }
                if ($request->hasFile('passbook')) {
                    $file = $request->file('passbook');
                    $this->validateFile($file, 'Bank Passbook / Cancel Cheque');
                    $fileFound = true;
                }
                if ($request->hasFile('dl')) {
                    $file = $request->file('dl');
                    $this->validateFile($file, 'Voter ID / Driving License');
                    $fileFound = true;
                }
                if ($request->hasFile('ld')) {
                    $file = $request->file('ld');
                    $this->validateFile($file, 'Land Documents');
                    $fileFound = true;
                }
                if ($request->hasFile('lp')) {
                    $file = $request->file('lp');
                    $this->validateFile($file, 'Land Photographs');
                    $fileFound = true;
                }
                if($fileFound){
                    foreach ($request->allFiles() as $key => $file) {
                        $userDocument = new UserDocuments();
                        $fileName = time() . '-' . $file->getClientOriginalName();
                        $file->move(public_path('assets/img/uploads/documents'), $fileName);
                        $userDocument->udc_name = $fileName;
                        $userDocument->udc_user_id = $request->uid;
                        $userDocument->udc_source = "Uploaded by admin";
                        switch($key){
                            case 'aadharf': $userDocument->udc_doc_type = 1;
                                break;
                            case 'aadharb': $userDocument->udc_doc_type = 2;
                                break;
                            case 'pancard': $userDocument->udc_doc_type = 3;
                                break;
                            case 'passbook': $userDocument->udc_doc_type = 4;
                                break;
                            case 'dl': $userDocument->udc_doc_type = 5;
                                break;
                            case 'ld': $userDocument->udc_doc_type = 6;
                                break;
                            case 'lp': $userDocument->udc_doc_type = 7;
                                break;
                        }
                        $userDocument->save();
                    }
                    return view('Admin.gotouserViewPage', ['uid' => $request->uid, 'code' => 200, 'msg' => 'Documents updated successfully!']);
                }else{
                    return view('Admin.gotouserViewPage', ['uid' => $request->uid, 'code' => 400, 'msg' => 'Please upload at least 1 file!']);
                }
            }else{
                return view('Admin.gotouserViewPage', ['uid' => $request->uid, 'code' => 400, 'msg' => 'User not found. Please try again later!']);
            }
        } catch (Exception $e) {
            return view('Admin.gotouserViewPage', ['uid' => $request->uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function viewUserCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $location = Location::where('loc_user_id','=',$request->uid)->where('loc_status','=',1)->first();
            $services = CompanyService::orderBy('cms_service_name', 'ASC')->get();
            if ($user && $services && $location) {
                return view('Admin.header') . view('Admin.view_user', compact('user', 'services','location')) . view('Admin.footer');
            }
            elseif ($user && $services) {
                return view('Admin.header') . view('Admin.view_user', compact('user', 'services')) . view('Admin.footer');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function editUserCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            if ($user) {
                return view('Admin.header') . view('Admin.edit_user', compact('user')) . view('Admin.footer');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function verifyDocumentsCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            if ($user) {
                $data = UserDocuments::where('udc_user_id', '=', $user->usr_id)->where('udc_status', '!=', '0')->orderBy('udc_doc_type', 'ASC')->get();
                return view('Admin.header') . view('Admin.verify_documents', compact('data', 'user')) . view('Admin.footer');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function reviewVerifiedDocumentsCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            if ($user) {
                return view('Admin.header') . view('Admin.review_documents', compact('user')) . view('Admin.footer');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function verifyNowDocumentCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
            'doc_id' => 'required|numeric'
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!',
            'doc_id.required' => 'Unable to process your request right now!',
            'doc_id.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            // Find user and document by IDs
            $user = WebUser::find($request->uid);
            $doc = UserDocuments::find($request->doc_id);
            if ($user && $doc) {
                // Mark document as verified
                $doc->udc_status = 2;
                if ($doc->save()) {
                    // Return success view
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status' => true]);
                }
                else {
                    // Failed to save document status
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status' => false]);
                }
            }
            else {
                // User or document not found
                return view('Admin.goToVerifyDocuments', ['uid' => $request->uid, 'status' => false]);
            }
        } catch (Exception $e) {
            // Log the exception for debugging
            Log::error('Error verifying document: ' . $e->getMessage());

            // Return failure view
            return view('Admin.goToVerifyDocuments', ['uid' => $request->uid, 'status' => false]);
        }
    }

    public function rejectNowDocumentCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
            'doc_id' => 'required|numeric'
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!',
            'doc_id.required' => 'Unable to process your request right now!',
            'doc_id.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $doc = UserDocuments::find($request->doc_id);
            if ($user && $doc) {
                $doc->udc_status = 3;
                if ($doc->save()) {
                    // Check if all required document types are verified
                    $requiredDocumentTypes = [1, 2, 3, 4, 7];
                    $verifiedDocumentsCount = UserDocuments::where('udc_user_id', $user->usr_id)
                        ->whereIn('udc_doc_type', $requiredDocumentTypes)
                        ->where('udc_status', 2)
                        ->count();
                    // Update user verification status
                    if ($verifiedDocumentsCount == count($requiredDocumentTypes)) {
                        $user->usr_verification_status = 1; // Fully verified
                    }
                    else {
                        $user->usr_verification_status = 0; // Not fully verified
                    }
                    $user->save();

                    // Return success view
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status' => true]);
                }
                else {
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status1' => false]);
                }
            }
            else {
                return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status1' => false]);
            }
        } catch (Exception $e) {
            return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status1' => false]);
        }
    }
    public function deleteNowDocumentCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
            'doc_id' => 'required|numeric'
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!',
            'doc_id.required' => 'Unable to process your request right now!',
            'doc_id.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $doc = UserDocuments::find($request->doc_id);
            if ($user && $doc) {
                $doc->udc_status = 0;
                if ($doc->save()) {
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status1' => true]);
                }
                else {
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status1' => false]);
                }
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewUserBankDetailsCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric'
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $bankDetails = UserBankDetail::where('ubd_usr_id', '=', $request->uid)->where('ubd_user_kyc_status', '!=', 0)->first();
            if ($user && $bankDetails) {
                return view('Admin.header') . view('Admin.user_bank_details_view', compact('user', 'bankDetails')) . view('Admin.footer');
            }
            else {
                return redirect()->back()->with('error', 'Details not updated!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateViewUserBankDetailsCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric'
        ], [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $bankList = BankList::orderBy('bnk_name','ASC')->get();
            $bankDetails = UserBankDetail::where('ubd_usr_id', '=', $request->uid)->where('ubd_user_kyc_status', '!=', 0)->first();
            if ($user && $bankDetails) {
                return view('Admin.header') . view('Admin.user_bank_edit', compact('user', 'bankList', 'bankDetails')) . view('Admin.footer');
            }elseif ($user) {
                return view('Admin.header') . view('Admin.user_bank_edit', compact('user', 'bankList')) . view('Admin.footer');
            }
            else {
                return redirect()->back()->with('error', 'Details not updated!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateUserBankDetailsCommand(Request $request)
    {
        $rules = [
            'uid' => 'required|numeric',
            'ubd_user_name_in_bank' => 'required|string|max:255',
            'ubd_user_bank_name' => 'required|string',
            'ubd_user_bank_name_other' => 'nullable|required_if:ubd_user_bank_name,Other|string|max:255',
            'ubd_user_bank_acc' => 'required|numeric',
            'ubd_user_ifsc' => 'required|string|size:11',
            'ubd_user_pan' => 'required|string|size:10',
            'ubd_user_bank_proof' => 'nullable|file|max:5120' // max 5MB
        ];
        $messages = [
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!',
            'ubd_user_name_in_bank.required' => 'Please enter the name as it appears in the bank.',
            'ubd_user_bank_name.required' => 'Please select a bank.',
            'ubd_user_bank_name_other.required_if' => 'Please specify the bank name.',
            'ubd_user_bank_acc.required' => 'Please enter the account number.',
            'ubd_user_bank_acc.numeric' => 'Please enter a valid account number.',
            'ubd_user_ifsc.required' => 'Please enter the IFSC code.',
            'ubd_user_pan.required' => 'Please enter the PAN number.',
            'ubd_user_bank_proof.max' => 'The bank proof file size must be less than 5MB.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return view('Admin.gotoUserBankEditPage', ['code' => 400, 'uid' => $request->uid, 'msg' => $firstError,]);
        }
        try {
            $user = WebUser::find($request->uid);
            if ($user) {
                $bankDetails = UserBankDetail::where('ubd_usr_id', '=', $request->uid)->where('ubd_user_kyc_status', '!=', 0)->first();
                if(!$bankDetails) {
                    $bankDetails = new UserBankDetail();
                }
                $bankDetails->ubd_usr_id = $user->usr_id;
                $bankDetails->ubd_user_name = $user->usr_first_name.' '.$user->usr_last_name;
                $bankDetails->ubd_user_pan = $request->ubd_user_pan;
                $bankDetails->ubd_user_name_in_bank = $request->ubd_user_name_in_bank;
                $bankDetails->ubd_user_bank_name = $request->ubd_user_bank_name;
                $bankDetails->ubd_user_bank_name_other = $request->ubd_user_bank_name_other;
                $bankDetails->ubd_user_bank_acc = $request->ubd_user_bank_acc;
                $bankDetails->ubd_user_ifsc = $request->ubd_user_ifsc;
                if ($request->hasFile('ubd_user_bank_proof')) {
                    $file = $request->file('ubd_user_bank_proof');
                    $fileName = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/documents'), $fileName);
                    $bankDetails->ubd_user_bank_proof = $fileName;
                }
                if($bankDetails->save()){
                    return view('Admin.gotoUserBankEditPage', ['code' => 200, 'uid' => $request->uid, 'msg' => 'Bank record updated successfully!',]);
                }else{
                    return view('Admin.gotoUserBankEditPage', ['code' => 400, 'uid' => $request->uid, 'msg' => 'Unable to update bank record right now. Please try again later!',]);
                }
            }
            else {
                return view('Admin.gotoUserBankEditPage', ['code' => 400, 'uid' => $request->uid, 'msg' => 'Something went wrong. Please try again later!']);
            }
        } catch (Exception $e) {
            return view('Admin.gotoUserBankEditPage', ['code' => 400, 'uid' => $request->uid, 'msg' => $e->getMessage()]);
        }
    }

    public function updateUserBankDetailsKYCCommand(Request $request)
    {
        try {
            $req = $request->ubd_user_kyc_status;
            if ($req == "") {
                return view('Admin.goToUserBankDetails', ['code' => 404, 'uid' => $request->uid]);
            }
            if (!is_numeric($req)) {
                return view('Admin.goToUserBankDetails', ['code' => 400, 'uid' => $request->uid]);
            }
            if ($req >= 1 && $req <= 4) {
                $user = WebUser::find($request->uid);
                $bankDetails = UserBankDetail::where('ubd_usr_id', '=', $request->uid)->where('ubd_user_kyc_status', '!=', 0)->first();
                if ($user && $bankDetails) {
                    $bankDetails->ubd_user_kyc_status = $request->ubd_user_kyc_status;
                    if ($bankDetails->save()) {
                        if ($req == 1) {
                            $string = $bankDetails->ubd_user_bank_acc;
                            $lastFourChars = substr($string, -4);

                            $optMessage = "Dear " . $user->usr_first_name . ", Your Documents received for verification are verified successfully, Aadhar,Pan,Photos and Bank " . $lastFourChars . " are forwarded to Operator. Regards ! BHRTIWEB";
                            // dd($optMessage);

                            $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513378567622');
                        }
                        return view('Admin.goToUserBankDetails', ['code' => 402, 'uid' => $request->uid]);
                    }
                    else {
                        return view('Admin.goToUserBankDetails', ['code' => 400, 'uid' => $request->uid]);
                    }
                }
                else {
                    return view('Admin.goToUserBankDetails', ['code' => 400, 'uid' => $request->uid]);
                }
            }
            else {
                return view('Admin.goToUserBankDetails', ['code' => 400, 'uid' => $request->uid]);
            }
        } catch (Exception $e) {
            return view('Admin.goToUserBankDetails', ['code' => 405, 'uid' => $request->uid, 'msg' => $e->getMessage()]);
        }
    }

    public function raiseNewInvoiceCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric'
        ], [
            'uid.required' => 'Something went wrong. Please try again later!',
            'uid.numeric' => 'Something went wrong. Please try again later!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            if ($user) {
                return view('Admin.header') . view('Admin.newInvoice', compact('user')) . view('Admin.footer');
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function viewUserInvoiceList(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric'
        ], [
            'uid.required' => 'Something went wrong. Please try again later!',
            'uid.numeric' => 'Something went wrong. Please try again later!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            if ($user) {
                $invoiceList = Invoice::where('inv_party_id', '=', $user->usr_id)->where('inv_status', '!=', 0)->get();
                return view('Admin.header') . view('Admin.viewInvoiceList', compact('user', 'invoiceList')) . view('Admin.footer');
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    private function changeInvoiceStatus($uid, $inv_id, $status)
    {
        $user = WebUser::find($uid);
        if ($user) {
            $invoice = Invoice::where('inv_id', '=', $inv_id)->where('inv_party_id', '=', $user->usr_id)->where('inv_status', '!=', 0)->first();
            if ($invoice) {
                $invoice->inv_status = $status;
                if ($invoice->save()) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function makeInvoicePaidCommand(Request $request)
    {
        try {
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if ($uid == 0 || $inv_id == 0) {
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }
            else {
                $user = WebUser::find($uid);
                $invoice = Invoice::find($inv_id);
                if ($this->changeInvoiceStatus($uid, $inv_id, 5)) {

                    $string = $invoice->inv_number;
                    $parts = explode('/', $string);
                    $lastTwoParts = implode('/', array_slice($parts, -2));
                    $optMessage = "Dear " . $user->usr_first_name . " " . $user->usr_last_name . ", Your " . 'Invoice ' . $lastTwoParts . " fee amount INR " . $invoice->inv_amount . " received successfully at BHRTIWEB, Please make sure to provide correct details and documents to avid file cancellation. BHRTIWEB";
                    $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513450643192');

                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }
                else {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        } catch (Exception $e) {
            return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoicePendingCommand(Request $request)
    {
        try {
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if ($uid == 0 || $inv_id == 0) {
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }
            else {
                if ($this->changeInvoiceStatus($uid, $inv_id, 4)) {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }
                else {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        } catch (Exception $e) {
            return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoicePartialPaidCommand(Request $request)
    {
        try {
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if ($uid == 0 || $inv_id == 0) {
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }
            else {
                if ($this->changeInvoiceStatus($uid, $inv_id, 2)) {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }
                else {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        } catch (Exception $e) {
            return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoiceRefundedCommand(Request $request)
    {
        try {
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if ($uid == 0 || $inv_id == 0) {
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }
            else {
                if ($this->changeInvoiceStatus($uid, $inv_id, 3)) {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }
                else {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        } catch (Exception $e) {
            return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoiceUnpaidCommand(Request $request)
    {
        try {
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if ($uid == 0 || $inv_id == 0) {
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }
            else {
                if ($this->changeInvoiceStatus($uid, $inv_id, 1)) {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }
                else {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        } catch (Exception $e) {
            return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoiceDeleteCommand(Request $request)
    {
        try {
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if ($uid == 0 || $inv_id == 0) {
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }
            else {
                if ($this->changeInvoiceStatus($uid, $inv_id, 0)) {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 200, 'msg' => 'Invoice deleted successfully']);
                }
                else {
                    return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        } catch (Exception $e) {
            return view('Admin.goToInvoiceListPage', ['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function invoiceViewCommand($id,$inv_id)
    {
        try{
            $user = WebUser::find($id);
            $services = CompanyService::get();
            $invoice = Invoice::find($inv_id);
            $company = CompanyInfo::find(1);
            $invoiceSettings = InvoiceSetting::find(1);
            // dd($invoice);
            if(($user && $user->usr_profile_status != 0) && ($invoice && $invoice->inv_status != 0) && ($company && $company->cmp_status != 0) && $invoiceSettings){
                $invoiceDescriptions = InvoiceDescriptionAmount::where('ida_inv_no','=',$invoice->inv_number)->where('ida_status','!=', 0)->get();
                return view('User.invoiceLayout1',compact('user','invoice', 'invoiceDescriptions','company','invoiceSettings','services'));
            }else{
                return view('Admin.goToInvoiceListPage', ['uid' => $id, 'code' => 400, 'msg' => 'Something went wrong. Please try after sometimes!']);
            }
        }catch(Exception $e){
            return view('Admin.goToInvoiceListPage', ['uid' => $id, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }

    public function raiseNewInvoiceFormSubmitCommand(Request $request)
    {
        try {
            $uid = $request->uid ?? 0;
            $inv_date_input = $request->inv_date;
            $due_date_input = $request->due_date;
            $customer_name = $request->customer_name;
            $customer_phone1 = $request->customer_phone1;
            $customer_phone2 = $request->customer_phone2;
            $customer_address1 = $request->customer_address1;
            $customer_address2 = $request->customer_address2;

            if ($uid == 0) {
                return redirect()->to('/admin/user-invoices-page')->with(['error' => 'Something went wrong. Please try again later!']);
            }

            if ($inv_date_input == '') {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Invoice date is required!']);
            }
            if ($due_date_input == '') {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Due date is required!']);
            }
            if ($due_date_input < $inv_date_input) {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Due date cannot be earlier than invoice date!']);
            }
            // Validate invoice date
            try {
                $inv_date = new \DateTime($inv_date_input);
                $inv_date = $inv_date->format('Y-m-d'); // Save in MySQL format
            } catch (Exception $e) {
                return view('Admin.goToRaiseNewInvoice', [
                    'uid' => $uid,
                    'code' => 400,
                    'msg' => 'Invalid invoice date provided!'
                ]);
            }

            // Validate due date
            try {
                $due_date = new \DateTime($due_date_input);
                $due_date = $due_date->format('Y-m-d'); // Save in MySQL format
            } catch (Exception $e) {
                return view('Admin.goToRaiseNewInvoice', [
                    'uid' => $uid,
                    'code' => 400,
                    'msg' => 'Invalid due date provided!'
                ]);
            }

            if ($customer_name == '') {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Name is required!']);
            }

            if ($customer_phone1 == '') {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Phone 1 is required!']);
            }
            elseif (!is_numeric($customer_phone1) || strlen($customer_phone1) != 10) {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Invalid phone 1 provided!']);
            }

            if ($customer_phone2 != '') {
                if (!is_numeric($customer_phone2) || strlen($customer_phone2) != 10) {
                    return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Invalid phone 2 provided!']);
                }
            }

            if ($customer_address1 == '') {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Address Line 1 is required!']);
            }
            if ($customer_address2 == '') {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Address Line 2 is required!']);
            }

            $user = WebUser::find($uid);
            $invoice_number = $user->usr_username;

            $countInvoice = Invoice::where('inv_party_id', '=', $user->usr_id)->count();
            $invoice_number = $invoice_number . '/IN' . ($countInvoice + 1);

            $inv_amount = 0.00;
            foreach ($request->inv_amount as $amount) {
                if ($amount == '' || $amount == null) {
                    continue;
                }
                elseif (!is_numeric($amount) || $amount <= 0) {
                    return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Invalid amount provided!']);
                }
                $inv_amount += (float) $amount;
            }

            $invoice = new Invoice();

            $invoice->inv_number = $invoice_number;
            $invoice->inv_party_id = $uid;
            $invoice->inv_party_name = $customer_name;
            $invoice->inv_party_address_1 = $customer_address1;
            $invoice->inv_party_address_2 = $customer_address2;
            $invoice->inv_party_mobile1 = $customer_phone1;
            $invoice->inv_party_mobile2 = $customer_phone2;
            $invoice->inv_amount = $inv_amount;
            $invoice->inv_date = $inv_date;
            $invoice->inv_due_date = $due_date;
            $invoice->inv_created_by = Session::get('uid');
            if (!$invoice->save()) {
                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong while saving invoice. Please try again after sometimes!']);
            }
            else {
                $string = $invoice_number;
                $parts = explode('/', $string);
                $lastTwoParts = implode('/', array_slice($parts, -2));

                $optMessage = "Dear Customer, Your " . $lastTwoParts . " INR " . $inv_amount . " fee at BHRTIWEB is due for processing, Please make sure to clear your dues immediately to avid file closure. BHRTIWEB";

                $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $customer_phone1 . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513430583099');
                Log::info('SMS API Response', ['status' => $response->status(), 'body' => $response->body()]);

                if (count($request->inv_desc_title) !== count($request->inv_amount)) {
                    return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Mismatch between descriptions and amounts!']);
                }
                foreach ($request->inv_desc_title as $key => $description) {
                    $invoiceDescription = new InvoiceDescriptionAmount();
                    if ($description == "" || $description == null) {
                        continue;
                    }
                    else {
                        $invoiceDescription->ida_inv_id = $invoice->inv_id;
                        $invoiceDescription->ida_inv_no = $invoice_number;
                        $invoiceDescription->ida_description = $description;
                        $invoiceDescription->ida_amount = $request->inv_amount[$key];
                        $invoiceDescription->save();
                    }
                }


                return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 200, 'msg' => 'Invoice Raised Successfully']);

            }
        } catch (Exception $e) {
            if ($uid == 0) {
                return redirect()->to('/admin/user-invoices-page')->with(['error' => $e->getMessage()]);
            }
            return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }

    public function updateCompanyCommand(Request $request)
    {
        $request->validate([
            'cmp_name' => 'required|string|max:255',
            'cmp_short_name' => 'required|string|max:255',
            'cmp_primary_email' => 'required|email|max:255',
            'cmp_mobile1' => 'required|numeric|digits:10',
            'cmp_gst_no' => 'required|string|max:15',
            'cmp_address1' => 'required|string|max:255',
            'cmp_mobile2' => 'nullable|numeric|digits:10',
            'cmp_mobile3' => 'nullable|numeric|digits:10',
            'cmp_support_email' => 'nullable|email|max:255',
            'cmp_contact_email' => 'nullable|email|max:255',
            'cmp_website' => 'nullable|string|max:255',
            'cmp_address2' => 'nullable|string|max:255',
            'cmp_address3' => 'nullable|string|max:255',
            'cmp_landmark' => 'nullable|string|max:255',
            'cmp_country' => 'nullable|string|max:100',
            'cmp_state' => 'nullable|string|max:100',
            'cmp_city' => 'nullable|string|max:100',
            'cmp_zip' => 'nullable|numeric|digits_between:5,6',
            'cmp_logo' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'cmp_name.required' => 'Company Name is required.',
            'cmp_name.string' => 'Company Name must be a valid string.',
            'cmp_name.max' => 'Company Name must not exceed 255 characters.',
            'cmp_short_name.required' => 'Company Short Name is required.',
            'cmp_short_name.string' => 'Company Short Name must be a valid string.',
            'cmp_short_name.max' => 'Company Short Name must not exceed 255 characters.',
            'cmp_primary_email.required' => 'Primary Email is required.',
            'cmp_primary_email.email' => 'Enter a valid Primary Email address.',
            'cmp_primary_email.max' => 'Primary Email must not exceed 255 characters.',
            'cmp_mobile1.required' => 'Phone 1 is required.',
            'cmp_mobile1.numeric' => 'Phone 1 must be a valid number.',
            'cmp_mobile1.digits' => 'Phone 1 must be exactly 10 digits.',
            'cmp_gst_no.required' => 'GST No. is required.',
            'cmp_gst_no.string' => 'GST No. must be a valid string.',
            'cmp_gst_no.max' => 'GST No. must not exceed 15 characters.',
            'cmp_address1.required' => 'Address Line 1 is required.',
            'cmp_address1.string' => 'Address Line 1 must be a valid string.',
            'cmp_address1.max' => 'Address Line 1 must not exceed 255 characters.',
            'cmp_mobile2.numeric' => 'Phone 2 must be a valid number.',
            'cmp_mobile2.digits' => 'Phone 2 must be exactly 10 digits.',
            'cmp_mobile3.numeric' => 'Phone 3 must be a valid number.',
            'cmp_mobile3.digits' => 'Phone 3 must be exactly 10 digits.',
            'cmp_support_email.email' => 'Enter a valid Support Email address.',
            'cmp_support_email.max' => 'Support Email must not exceed 255 characters.',
            'cmp_contact_email.email' => 'Enter a valid Contact Email address.',
            'cmp_contact_email.max' => 'Contact Email must not exceed 255 characters.',
            'cmp_website.string' => 'Company Website must be a valid string.',
            'cmp_website.max' => 'Company Website must not exceed 255 characters.',
            'cmp_address2.string' => 'Address Line 2 must be a valid string.',
            'cmp_address2.max' => 'Address Line 2 must not exceed 255 characters.',
            'cmp_address3.string' => 'Address Line 3 must be a valid string.',
            'cmp_address3.max' => 'Address Line 3 must not exceed 255 characters.',
            'cmp_landmark.string' => 'Landmark must be a valid string.',
            'cmp_landmark.max' => 'Landmark must not exceed 255 characters.',
            'cmp_country.string' => 'Country must be a valid string.',
            'cmp_country.max' => 'Country must not exceed 100 characters.',
            'cmp_state.string' => 'State must be a valid string.',
            'cmp_state.max' => 'State must not exceed 100 characters.',
            'cmp_city.string' => 'City must be a valid string.',
            'cmp_city.max' => 'City must not exceed 100 characters.',
            'cmp_zip.numeric' => 'Pin Code must be a valid number.',
            'cmp_zip.digits_between' => 'Pin Code must be between 5 and 6 digits.',
            'cmp_logo.file' => 'Company Logo must be a valid file.',
            'cmp_logo.image' => 'Company Logo must be an image file.',
            'cmp_logo.mimes' => 'Company Logo must be a jpeg, png, or jpg file.',
            'cmp_logo.max' => 'Company Logo must not exceed 2MB in size.'
        ]);
        try {
            $companyInfo = CompanyInfo::find(1);
            $companyInfo->cmp_name = $request->cmp_name;
            $companyInfo->cmp_short_name = $request->cmp_short_name;
            $companyInfo->cmp_primary_email = $request->cmp_primary_email;
            $companyInfo->cmp_mobile1 = $request->cmp_mobile1;
            $companyInfo->cmp_gst_no = $request->cmp_gst_no;
            $companyInfo->cmp_address1 = $request->cmp_address1;
            $companyInfo->cmp_mobile2 = $request->cmp_mobile2;
            $companyInfo->cmp_mobile3 = $request->cmp_mobile3;
            $companyInfo->cmp_support_email = $request->cmp_support_email;
            $companyInfo->cmp_contact_email = $request->cmp_contact_email;
            $companyInfo->cmp_website = $request->cmp_website;
            $companyInfo->cmp_address2 = $request->cmp_address2;
            $companyInfo->cmp_address3 = $request->cmp_address3;
            $companyInfo->cmp_landmark = $request->cmp_landmark;
            $companyInfo->cmp_country = $request->cmp_country;
            $companyInfo->cmp_state = $request->cmp_state;
            $companyInfo->cmp_city = $request->cmp_city;
            $companyInfo->cmp_zip = $request->cmp_zip;
            // $companyInfo->cmp_logo = $request->cmp_logo;
            if ($request->hasFile('cmp_logo')) {
                $file = $request->file('cmp_logo');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $companyInfo->cmp_logo = $fileName;
            }
            if ($companyInfo->save()) {
                return redirect()->back()->with('success', 'Company information updated successfully!');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong. Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateCompanyBankCommand(Request $request){
        $request->validate([
            'cbd_bank_name' => 'required|string|max:255',
            'cbd_account_number' => 'required|numeric',
            'cbd_ifsc_code' => 'required|string|max:11',
            'cbd_branch' => 'nullable|string|max:255',
            'cbd_upi_name' => 'nullable|string|max:255',
            'cbd_upi_id' => 'nullable|string',
            'cbd_qr_code' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cbd_is_hidden' => 'required|numeric'
        ], [
            'cbd_bank_name.required' => 'Please select a bank name.',
            'cbd_account_number.required' => 'Account number is required.',
            'cbd_account_number.numeric' => 'Account number must be a valid number.',
            'cbd_ifsc_code.required' => 'IFSC code is required.',
            'cbd_ifsc_code.max' => 'IFSC code cannot be more than 11 characters.',
            'cbd_branch.max' => 'Branch name cannot exceed 255 characters.',
            'cbd_upi_name.max' => 'UPI name cannot exceed 255 characters.',
            'cbd_qr_code.mimes' => 'QR code must be a file of type: jpeg, png, jpg, gif, svg.',
            'cbd_qr_code.max' => 'QR code size must not exceed 2MB.',
            'cbd_is_hidden.required' => 'Please select bank details visibility!',
            'cbd_is_hidden.numeric' => 'Invalid bank details visibility!'
        ]);
        try{
            $bank = CompanyBankDetail::find(1);
            $bank->cbd_bank_name = $request->cbd_bank_name;
            $bank->cbd_account_number = $request->cbd_account_number;
            $bank->cbd_ifsc_code = $request->cbd_ifsc_code;
            $bank->cbd_branch = $request->cbd_branch;
            $bank->cbd_upi_name = $request->cbd_upi_name;
            $bank->cbd_upi_id = $request->cbd_upi_id;
            $bank->cbd_is_hidden = $request->cbd_is_hidden;
            if ($request->hasFile('cbd_qr_code')) {
                $file = $request->file('cbd_qr_code');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/documents'), $fileName);
                $bank->cbd_qr_code = $fileName;
            }
            if($bank->save()){
                return redirect()->back()->with('success','Company bank details updated successfully!');
            }else{
                return redirect()->back()->with('error','Unable to update company bank details right now. Please try again later!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateApprovalLetterCommand(Request $request)
    {
        $request->validate([
            'als_header_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'als_footer_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'als_body_img_1' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'als_body_img_2' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'als_default_welcome_msg' => 'required|string|max:1000',
        ], [
            'als_header_img.image' => 'Header Logo must be an image file.',
            'als_header_img.mimes' => 'Header Logo must be a file of type: jpeg, png, jpg.',
            'als_header_img.max' => 'Header Logo must not exceed 2MB in size.',
            'als_footer_img.image' => 'Footer Logo must be an image file.',
            'als_footer_img.mimes' => 'Footer Logo must be a file of type: jpeg, png, jpg.',
            'als_footer_img.max' => 'Footer Logo must not exceed 2MB in size.',
            'als_body_img_1.image' => 'Body Logo 1 must be an image file.',
            'als_body_img_1.mimes' => 'Body Logo 1 must be a file of type: jpeg, png, jpg.',
            'als_body_img_1.max' => 'Body Logo 1 must not exceed 2MB in size.',
            'als_body_img_2.image' => 'Body Logo 2 must be an image file.',
            'als_body_img_2.mimes' => 'Body Logo 2 must be a file of type: jpeg, png, jpg.',
            'als_body_img_2.max' => 'Body Logo 2 must not exceed 2MB in size.',
            'als_default_welcome_msg.required' => 'Welcome Message is required.',
            'als_default_welcome_msg.string' => 'Welcome Message must be valid text.',
            'als_default_welcome_msg.max' => 'Welcome Message must not exceed 1000 characters.',
        ]);
        try {
            $approvalSetting = ApprovalLetterSetting::find(1);
            if ($request->hasFile('als_header_img')) {
                $file = $request->file('als_header_img');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $approvalSetting->als_header_img = $fileName;
            }
            if ($request->hasFile('als_footer_img')) {
                $file = $request->file('als_footer_img');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $approvalSetting->als_footer_img = $fileName;
            }
            if ($request->hasFile('als_body_img_1')) {
                $file = $request->file('als_body_img_1');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $approvalSetting->als_body_img_1 = $fileName;
            }
            if ($request->hasFile('als_body_img_2')) {
                $file = $request->file('als_body_img_2');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $approvalSetting->als_body_img_2 = $fileName;
            }
            $approvalSetting->als_default_welcome_msg = $request->als_default_welcome_msg;
            if ($approvalSetting->save()) {
                return redirect()->back()->with('success', 'Approval letter settings updated successfully');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong. Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateInvoiceCommand(Request $request)
    {
        $request->validate([
            'ins_header_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'ins_footer_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'ins_body_img_1' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'ins_body_img_2' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'ins_stamp' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'ins_website' => 'required|url',
        ], [
            'ins_header_img.image' => 'Header Logo must be an image file.',
            'ins_header_img.mimes' => 'Header Logo must be a file of type: jpeg, png, jpg.',
            'ins_header_img.max' => 'Header Logo must not exceed 2MB in size.',
            'ins_footer_img.image' => 'Footer Logo must be an image file.',
            'ins_footer_img.mimes' => 'Footer Logo must be a file of type: jpeg, png, jpg.',
            'ins_footer_img.max' => 'Footer Logo must not exceed 2MB in size.',
            'ins_body_img_1.image' => 'Body Logo 1 must be an image file.',
            'ins_body_img_1.mimes' => 'Body Logo 1 must be a file of type: jpeg, png, jpg.',
            'ins_body_img_1.max' => 'Body Logo 1 must not exceed 2MB in size.',
            'ins_body_img_2.image' => 'Body Logo 2 must be an image file.',
            'ins_body_img_2.mimes' => 'Body Logo 2 must be a file of type: jpeg, png, jpg.',
            'ins_body_img_2.max' => 'Body Logo 2 must not exceed 2MB in size.',
            'ins_stamp.image' => 'Stamp must be an image file.',
            'ins_stamp.mimes' => 'Stamp must be a file of type: jpeg, png, jpg.',
            'ins_stamp.max' => 'Stamp must not exceed 2MB in size.',
            'ins_website.required' => 'Footer URL is required.',
            'ins_website.url' => 'Footer URL must be a valid URL.',
        ]);
        try {
            $invoiceSetting = InvoiceSetting::find(1);
            if ($request->hasFile('ins_header_img')) {
                $file = $request->file('ins_header_img');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $invoiceSetting->ins_header_img = $fileName;
            }
            if ($request->hasFile('ins_footer_img')) {
                $file = $request->file('ins_footer_img');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $invoiceSetting->ins_footer_img = $fileName;
            }
            if ($request->hasFile('ins_body_img_1')) {
                $file = $request->file('ins_body_img_1');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $invoiceSetting->ins_body_img_1 = $fileName;
            }
            if ($request->hasFile('ins_body_img_2')) {
                $file = $request->file('ins_body_img_2');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $invoiceSetting->ins_body_img_2 = $fileName;
            }
            if ($request->hasFile('ins_stamp')) {
                $file = $request->file('ins_stamp');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $invoiceSetting->ins_stamp = $fileName;
            }
            $invoiceSetting->ins_website = $request->ins_website;
            if ($invoiceSetting->save()) {
                return redirect()->back()->with('success', 'Invoice settings updated successfully!');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong. Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateAdminAccountCommand(Request $request)
    {
        $request->validate([
            'adm_first_name' => 'required|string|min:2',
            'adm_last_name' => 'required|string|min:2',
            'adm_email' => 'required|email',
            'adm_mobile' => 'required|numeric|digits:10',
            'adm_current_password' => 'required|string', // Always required to update the profile
            'adm_new_password' => 'nullable|string|min:8|same:adm_confirm_new_password', // Validate new password if provided
            'adm_confirm_new_password' => 'nullable|required_with:adm_new_password|string|same:adm_new_password', // Confirm new password
            'adm_profile_photo' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Custom error messages
            'adm_first_name.required' => 'Admin First Name is required.',
            'adm_last_name.required' => 'Admin Last Name is required.',
            'adm_email.required' => 'Admin Email is required.',
            'adm_mobile.required' => 'Admin Mobile is required.',
            'adm_current_password.required' => 'Current Password is required.',
            'adm_new_password.min' => 'New Password must be at least 8 characters.',
            'adm_new_password.same' => 'New Password and Confirm New Password must match.',
            'adm_confirm_new_password.required_with' => 'Confirm New Password is required when setting a new password.',
            'adm_profile_photo.mimes' => 'Profile photo must be an image file (jpeg, png, jpg).',
        ]);

        try {
            $admin = Admin::find(Session::get('uid'));
            if ($admin && Hash::check($request->adm_current_password, $admin->adm_password)) {
                if ($request->hasFile('adm_profile_photo')) {
                    $file = $request->file('adm_profile_photo');
                    $fileName = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('assets/img/uploads/documents'), $fileName);
                    $admin->adm_profile_photo = $fileName;
                }
                $admin->adm_first_name = $request->adm_first_name;
                $admin->adm_last_name = $request->adm_last_name;
                $admin->adm_email = $request->adm_email;
                $admin->adm_mobile = $request->adm_mobile;
                if ($request->adm_new_password != '' && $request->adm_new_password != null) {
                    $admin->adm_password = Hash::make($request->adm_new_password);
                    $admin->adm_visible_password = $request->adm_new_password;
                }
                if ($admin->save()) {
                    return redirect()->back()->with('success', 'Account details updated successfully!');
                }
                else {
                    return redirect()->back()->with('error', 'Something went wrong. Please try again later!');
                }
            }
            else {
                return redirect()->back()->with('error', 'Current password is wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sendReminderCommand(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date|before_or_equal:today',
            'to_date' => 'nullable|date|after_or_equal:from_date|before_or_equal:today',
            'rem_type' => 'required|in:1,2',
            'rem_to' => 'required|in:1,2',
            'usr_username' => 'required_if:rem_to,1',
        ], [
            'from_date.required' => 'Please select a start date.',
            'from_date.date' => 'The start date must be a valid date.',
            'from_date.before_or_equal' => 'The start date cannot be a future date.',
            'to_date.date' => 'The end date must be a valid date.',
            'to_date.after_or_equal' => 'The end date must be the same or later than the start date.',
            'to_date.before_or_equal' => 'The end date cannot be a future date.',
            'rem_type.required' => 'Please select a reminder type.',
            'rem_type.in' => 'The selected reminder type is invalid.',
            'rem_to.required' => 'Please select whom to remind.',
            'rem_to.in' => 'The selected option for whom to remind is invalid.',
            'usr_username.required_if' => "User's file or mobile number is required when reminding a single person.",
        ]);

        try {
            $dateFrom = $request->from_date;
            $dateTo = $request->to_date ?? today();
            $remindType = $request->rem_type;
            $remindTo = $request->rem_to;
            $userFileOrMobile = $request->usr_username;

            if ($remindTo == 1) {
                $user = WebUser::where('usr_username', '=', $userFileOrMobile)->orWhere('usr_mobile', '=', $userFileOrMobile)->where('usr_profile_status', '!=', 0)->first();
                // dd($user);
                $string = $user->usr_username;
                $parts = explode('/', $string);
                $lastPart = implode('/', array_slice($parts, -1));
                if ($user) {
                    if ($remindType == 1 && $user->usr_verification_status == 0) {
                        // Due KYC Single
                        $optMessage = "Dear " . $user->usr_first_name . ", Your registration " . $lastPart . " at BHRTI WEB is successful, Documents received/required for verification are pending Regards ! BHRTI";
                        $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513344378719');
                        return redirect()->back()->with('success', 'KYC Reminder sms sent to the User: ' . $user->usr_first_name . " " . $user->usr_last_name . ", File number: " . $user->usr_username);
                    }
                    else if ($remindType == 1 && $user->usr_verification_status == 1) {
                        return redirect()->back()->with('success', 'KYC is already completed for User: ' . $user->usr_first_name . " " . $user->usr_last_name . ", File number: " . $user->usr_username);
                    }
                    elseif ($remindType == 2) {
                        // Due Invoice Single
                        $finalDue = Invoice::where("inv_party_id", $user->usr_id)->whereIn('inv_status', [1, 2, 3, 4])->sum('inv_amount');
                        if ($finalDue > 0) {
                            $optMessage = "Dear " . $user->usr_first_name . ", Your registration at BHRTIWEB " . 'fee INR ' . $finalDue . " due for processing, Please make sure to clear your dues timely " . 'to avoid closure' . ". FISBHT";
                            $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513404119124');
                            return redirect()->back()->with('success', 'Invoice Reminder sms sent to the User: ' . $user->usr_first_name . " " . $user->usr_last_name . ", File number: " . $user->usr_username . ", Due Amount: " . $finalDue);
                        }
                        else {
                            return redirect()->back()->with('success', 'No Invoice Dues for the User: ' . $user->usr_first_name . " " . $user->usr_last_name . ", File number: " . $user->usr_username);
                        }
                    }
                    else {
                        return redirect()->back()->with("error", "Something went wrong. Please try again later!");
                    }
                }
                else {
                    return redirect()->back()->with("error", "Something went wrong. Please try again later!");
                }

            }
            elseif ($remindTo == 2) {
                if ($remindType == 1) {
                    // Due KYC All
                    $users = WebUser::where('usr_verification_status', '=', 0)
                        ->where('usr_profile_status', '!=', 0)
                        ->whereBetween('created_at', [$dateFrom, $dateTo])
                        ->get();

                    if ($users->isEmpty()) {
                        return redirect()->back()->with('success', 'No users found with pending KYC between the selected dates.');
                    }

                    $count = 0;
                    foreach ($users as $user) {
                        $string = $user->usr_username;
                        $parts = explode('/', $string);
                        $lastPart = implode('/', array_slice($parts, -1));
                        $optMessage = "Dear " . $user->usr_first_name . ", Your registration " . $lastPart . " at BHRTI WEB is successful, Documents received/required for verification are pending Regards ! BHRTI";
                        $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513344378719');
                        $count++;
                    }

                    return redirect()->back()->with('success', 'KYC Reminder SMS sent to ' . $count . ' users with pending KYC between the selected dates.');

                }
                elseif ($remindType == 2) {
                    // Due Invoice All
                    $users = WebUser::where('usr_profile_status', '!=', 0)
                        ->whereBetween('created_at', [$dateFrom, $dateTo])
                        ->get();

                    if ($users->isEmpty()) {
                        return redirect()->back()->with('success', 'No users with due invoices between the selected dates.');
                    }

                    $count = 0;

                    foreach ($users as $user) {
                        $finalDue = Invoice::where("inv_party_id", "=", $user->usr_id)->whereIn('inv_status', [1, 2, 3, 4])->sum('inv_amount');

                        if ($finalDue > 0) {
                            $optMessage = "Dear " . $user->usr_first_name . ", Your registration at BHRTIWEB has an outstanding fee of INR " . $finalDue . " due. Please clear your dues to avoid closure. Regards, FISBHT";
                            $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513404119124');
                            $count++;
                        }
                    }

                    return redirect()->back()->with('success', 'Invoice Reminder SMS sent to ' . $count . ' users with due invoices between the selected dates.');

                }
                else {
                    return redirect()->back()->with("error", "Something went wrong. Please try again later!");
                }
            }
            else {
                return redirect()->back()->with("error", "Something went wrong. Please try again later!");
            }
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }

    }

    public function uploadFileCommand(Request $request)
    {
        $request->validate([
            'file_title' => 'required',
            'file_subtitle' => 'required',
            'file' => 'required|file'
        ], [
            'file_title.required' => 'File title is required!',
            'file_subtitle.required' => 'File subtitle is required!',
            'file.required' => 'Please upload a file!',
            'file.file' => 'Invalid file!'
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('downloads'), $fileName);

                $upload = new Downloadable();
                $upload->dwn_title = $request->file_title;
                $upload->dwn_subtitle = $request->file_subtitle;
                $upload->dwn_file = $fileName;
                if ($upload->save()) {
                    return redirect()->back()->with('success', 'File uploaded!');
                }
                else {
                    return redirect()->back()->with('error', 'Unable to save files right now. Please try again later!');
                }
            }
            else {
                return redirect()->back()->with('error', 'Please upload a file!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function hideFileCommand(Request $request)
    {
        $request->validate([
            'file_id' => 'required|numeric'
        ], [
            'file_id.required' => 'Unable to process your request right now. Please try again later!',
            'file_id.numeric' => 'Unable to process your request right now. Please try again later!'
        ]);
        try {
            $file = Downloadable::find($request->file_id);
            if ($file) {
                $file->dwn_is_hidden = 1;
                if ($file->save()) {
                    return redirect()->back()->with('success', 'File status updated successfully!');
                }
                else {
                    return redirect()->back()->with('error', 'Requested file not found. Please try again later!');
                }
            }
            else {
                return redirect()->back()->with('error', 'Requested file not found. Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function showFileCommand(Request $request)
    {
        $request->validate([
            'file_id' => 'required|numeric'
        ], [
            'file_id.required' => 'Unable to process your request right now. Please try again later!',
            'file_id.numeric' => 'Unable to process your request right now. Please try again later!'
        ]);
        try {
            $file = Downloadable::find($request->file_id);
            if ($file) {
                $file->dwn_is_hidden = 0;
                if ($file->save()) {
                    return redirect()->back()->with('success', 'File status updated successfully!');
                }
                else {
                    return redirect()->back()->with('error', 'Requested file not found. Please try again later!');
                }
            }
            else {
                return redirect()->back()->with('error', 'Requested file not found. Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function deleteFileCommand(Request $request)
    {
        $request->validate([
            'file_id' => 'required|numeric'
        ], [
            'file_id.required' => 'Unable to process your request right now. Please try again later!',
            'file_id.numeric' => 'Unable to process your request right now. Please try again later!'
        ]);
        try {
            $file = Downloadable::find($request->file_id);
            if ($file) {
                $file->dwn_status = 0;
                if ($file->save()) {
                    return redirect()->back()->with('success', 'File deleted successfully!');
                }
                else {
                    return redirect()->back()->with('error', 'Requested file not found. Please try again later!');
                }
            }
            else {
                return redirect()->back()->with('error', 'Requested file not found. Please try again later!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewApprovalLetter($id){
        $user = WebUser::find($id);
        $companyInfos = CompanyInfo::find(1);
        $aprovalSetting = ApprovalLetterSetting::find(1);
        $services = CompanyService::get();
        if($user && $user->usr_verification_status == 1 && $companyInfos){
            return view('User.approvalLetterLayout1',compact('user','companyInfos','aprovalSetting','services'));
        }else{
            return redirect()->back()->with('error','File is not approved yet!');
        }
    }

    public function getCompanyInfo()
    {
        $company = CompanyInfo::find(1);
        return response()->json($company);
    }

    private function userApproval($uid, $status){
        $webUser = WebUser::find($uid);
        if($webUser){
            $webUser->usr_verification_status = $status;
            if($webUser->save()){
                return true;
            }
        }
        return false;
    }

    public function userApprove(Request $request){
        if($this->userApproval($request->uid,1)){
            $user = WebUser::find($request->uid);
            $string = $user->usr_username;
            $parts = explode('/', $string);
            $lastTwoParts = implode('/', array_slice($parts, -1));
            $optMessage = "Dear " . $user->usr_first_name . ", Your registration " . $lastTwoParts . " at BHRTI WEB is successful, Documents received/required for verification are APPROVED Regards ! BHRTI";
            $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $user->usr_mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513344378719');
            return redirect()->back()->with('success', 'User approved successfully!');
        }
    }
    public function userReject(Request $request){
        if($this->userApproval($request->uid,0)){
            return redirect()->back()->with('success', 'User rejected successfully!');
        }
    }

    public function fetchUserByPhone(Request $request){
        $request->validate([
            'mobile' => 'required|numeric|digits:10'
        ]);
        $user = WebUser::where('usr_mobile','=', $request->mobile)->where('usr_profile_status','=','1')->first();
        if($user){
            return response()->json($user);
        }else{
            return response()->json(false);
        }
    }

    public function submitInsuranceForm(Request $request){
        $request->validate([
            'mobile' => 'required|numeric|digits:10',
            'policy'=> 'required',
            'customerName' => 'required',
            'nomineeName' => 'required',
            'sumAssured' => 'required|numeric',
            'insurancePremium' => 'required|numeric',
            'paidTill' => 'required|date',
            'balanceAmount' => 'required|numeric'
        ],[
            'mobile.required' => 'Mobile number is required!',
            'mobile.numeric' => 'Invalid mobile number!',
            'mobile.digits' => 'Invalid mobile number!',
            'policy.required' => 'policy number is required!',
            'customerName.required' => 'Customer name is required!',
            'nomineeName.required' => 'Nominee name is required!',
            'sumAssured.required' => 'Sum assured is required!',
            'sumAssured.numeric' => 'Invalid sum assured!',
            'insurancePremium.required' => 'Insurance premium is required!',
            'insurancePremium.numeric' => 'Invalid insurance premium!',
            'paidTill.required' => 'Paid till is required!',
            'paidTill.date' => 'Invalid paid till value!',
            'balanceAmount.required' => 'Balance amount is required!',
            'balanceAmount.numeric' => 'Invalid balance amount!'
        ]);
        try{
            $user = WebUser::where('usr_mobile','=',$request->mobile)->first();
            if($user){
                $paidTill = Carbon::createFromFormat('d M Y', $request->paidTill)->format('Y-m-d');
                $insurance = UserInsurance::create([
                    'uin_policy_number' => $request->policy,
                    'uin_insured_id' => $user->usr_id,
                    'uin_insured_name' => $request->customerName,
                    'uin_nominee' => $request->nomineeName,
                    'uin_sum_assured' => $request->sumAssured,
                    'uin_insurance_premium' => $request->insurancePremium,
                    'uin_paid_till' => $paidTill,
                    'uin_balance_amount' => $request->balanceAmount,
                    'uin_status' => 1
                ]);
                if($insurance){
                    return redirect()->back()->with('success','Insurance issued successfully to '.$request->customerName);
                }else{
                    return redirect()->back()->with('error', 'Unable to issue insurance right now! Please try again later!');
                }
            }else{
                return redirect()->back()->with('error', 'User not found!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // public function makeFirstAdmin()
    // {
    //     $adm_first_name = "Super";
    //     $adm_last_name = "Admin";
    //     $adm_email = "bhartiinfrateltelecon@gmail.com";
    //     $adm_mobile = "1234567899";
    //     $adm_username = "SA07102024";
    //     $adm_visible_password = "bhartiinfrateltelecon@gmail.com@";
    //     $admin = new Admin();
    //     $adm_password = Hash::make($adm_visible_password);
    //     $admin->adm_first_name = $adm_first_name;
    //     $admin->adm_last_name = $adm_last_name;
    //     $admin->adm_email = $adm_email;
    //     $admin->adm_mobile = $adm_mobile;
    //     $admin->adm_username = $adm_username;
    //     $admin->adm_password = $adm_password;
    //     $admin->adm_visible_password = $adm_visible_password;
    //     if ($admin->save()) {
    //         echo "Admin Created Email -> " . $adm_email . " | Password -> " . $adm_visible_password;
    //     }
    //     else {
    //         echo "Something went wrong!";
    //     }
    // }
}
