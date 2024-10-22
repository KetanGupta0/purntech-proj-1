<?php

namespace App\Http\Controllers;

use App\Models\ApprovalLetterSetting;
use App\Models\BankList;
use App\Models\CompanyBankDetail;
use App\Models\CompanyInfo;
use App\Models\CompanyService;
use App\Models\Downloadable;
use App\Models\Invoice;
use App\Models\InvoiceDescriptionAmount;
use App\Models\InvoiceSetting;
use App\Models\Location;
use App\Models\UserBankDetail;
use App\Models\UserDocuments;
use App\Models\UserTransaction;
use App\Models\WebUser;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function userLoginView()
    {
        return view('header') . view('User.login') . view('footer');
    }

    public function userDashboardView()
    {
        $user = WebUser::find(Session::get('uid'));
        // List of profile fields
        $profileFields = [
            'usr_first_name',
            'usr_last_name',
            'usr_father',
            'usr_mother',
            'usr_gender',
            'usr_dob',
            'usr_email',
            'usr_mobile',
            'usr_alt_mobile',
            'usr_full_address',
            'usr_landmark',
            'usr_profile_photo'
        ];
        $totalProfileFields = count($profileFields);
        $filledProfileFields = 0;
        foreach ($profileFields as $field) {
            if (!empty($user->$field)) {
                $filledProfileFields++;
            }
        }
        $profileCompletionPercentage = ($filledProfileFields / $totalProfileFields) * 100;
        $profileCompletionPercentage = round($profileCompletionPercentage, 2);

        $documentTypes = ['1', '2', '3', '4', '5', '6', '7'];
        $totalDocuments = count($documentTypes);
        $uploadedDocuments = UserDocuments::where('udc_user_id', $user->usr_id)
            ->whereIn('udc_doc_type', $documentTypes)
            ->where(function ($query) {
                $query->where('udc_status', '!=', '0')
                    ->where('udc_status', '!=', '3');
            })
            ->count();
        $documentUploadPercentage = ($uploadedDocuments / $totalDocuments) * 100;
        $documentUploadPercentage = round($documentUploadPercentage, 2);

        $ignoredTypes = [0, 4];
        $bankDetails = UserBankDetail::where('ubd_usr_id', '=', Session::get('uid'))->whereNotIn('ubd_user_kyc_status', $ignoredTypes)->first();
        $bankDetailsFields = [
            'ubd_user_name',
            'ubd_user_pan',
            'ubd_user_name_in_bank',
            'ubd_user_bank_name',
            'ubd_user_bank_acc',
            'ubd_user_ifsc',
            'ubd_user_bank_proof'
        ];
        $totalBankDetailsFields = count($bankDetailsFields);
        $filledBankDetailsFields = 0;
        foreach ($bankDetailsFields as $field) {
            if (!empty($bankDetails->$field)) {
                $filledBankDetailsFields++;
            }
        }

        $bankDetailsCompletionPercentage = ($filledBankDetailsFields / $totalBankDetailsFields) * 100;
        $bankDetailsCompletionPercentage = round($bankDetailsCompletionPercentage, 2);

        $companyBankDetails = CompanyBankDetail::find(1);

        $invoices = Invoice::where('inv_party_id', '=', $user->usr_id)->where('inv_status', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('User.header') . view('User.dashboard', compact('user', 'profileCompletionPercentage', 'companyBankDetails', 'documentUploadPercentage', 'bankDetailsCompletionPercentage', 'invoices')) . view('User.footer');
    }
    public function profileView()
    {
        $user = WebUser::find(Session::get('uid'));
        $profileFields = [
            'usr_first_name',
            'usr_last_name',
            'usr_father',
            'usr_mother',
            'usr_gender',
            'usr_dob',
            'usr_email',
            'usr_mobile',
            'usr_alt_mobile',
            'usr_full_address',
            'usr_landmark',
            'usr_profile_photo'
        ];
        $totalProfileFields = count($profileFields);
        $filledProfileFields = 0;
        foreach ($profileFields as $field) {
            if (!empty($user->$field)) {
                $filledProfileFields++;
            }
        }
        $profileCompletionPercentage = ($filledProfileFields / $totalProfileFields) * 100;
        $profileCompletionPercentage = round($profileCompletionPercentage, 2);
        return view('User.header') . view('User.profile', compact('user', 'profileCompletionPercentage')) . view('User.footer');
    }
    public function documentsView()
    {
        return view('User.header') . view('User.documents') . view('User.footer');
    }
    public function invoicesView()
    {
        $data = Invoice::where('inv_party_id', '=', Session::get('uid'))->where('inv_status', '!=', 0)->get();
        return view('User.header') . view('User.invoices', compact('data')) . view('User.footer');
    }
    public function appravalLetterView()
    {
        $user = WebUser::find(Session::get('uid'));
        return view('User.header') . view('User.approvalLetter', compact('user')) . view('User.footer');
    }
    public function bankDetailsView()
    {
        $data = UserBankDetail::where('ubd_usr_id', '=', Session::get('uid'))->where('ubd_user_kyc_status', '!=', 0)->first();
        $banks = BankList::where('bnk_status', '=', 1)->orderBy('bnk_name', 'ASC')->get();
        if ($data) {
            return view('User.header') . view('User.bank_details', compact('data', 'banks')) . view('User.footer');
        }
        else {
            return view('User.header') . view('User.bank_details', compact('banks')) . view('User.footer');
        }
    }
    public function paymentsView()
    {
        try {
            $user = WebUser::find(Session::get('uid'));
            $companyBankDetails = CompanyBankDetail::find(1);
            if ($user) {
                return view('User.header') . view('User.payments', compact('user', 'companyBankDetails')) . view('User.footer');
            }
            else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function downloadView()
    {
        try {
            $downloads = Downloadable::where('dwn_is_hidden', '=', 0)->where('dwn_status', '!=', 0)->get();
            return view('User.header') . view('User.download', compact('downloads')) . view('User.footer');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function helpView()
    {
        return view('User.header') . view('User.help') . view('User.footer');
    }

    public function updateUserProfile(Request $request)
    {
        try {
            $user = WebUser::find(Session::get('uid'));
            if ($request->hasFile('usr_profile_photo')) {
                $file = $request->file('usr_profile_photo');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/documents'), $fileName);
                $user->usr_profile_photo = $fileName;
            }
            if ($request->usr_alt_mobile != '') {
                $request->validate([
                    'usr_alt_mobile' => 'digits:10|numeric'
                ], [
                    'usr_alt_mobile.digits' => 'Invalid alternate mobile number!',
                    'usr_alt_mobile.numeric' => 'Invalid alternate mobile number!'
                ]);
                $user->usr_alt_mobile = $request->usr_alt_mobile;
            }
            $user->usr_gender = $request->usr_gender;
            if ($request->usr_dob != "")
                $request->validate([
                    "usr_dob" => "date"
                ]);

            $user->usr_dob = date('Y/m/d', strtotime($request->usr_dob));
            $user->usr_father = $request->usr_father;
            $user->usr_mother = $request->usr_mother;
            $user->usr_full_address = $request->usr_full_address;
            $user->usr_landmark = $request->usr_landmark;
            $user->save();
            return redirect()->back()->with('success', 'Profile Updated Successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getUserDocsAJAX()
    {
        try {
            $user = WebUser::find(Session::get('uid'));
            $userDocs = UserDocuments::where('udc_user_id', '=', $user->usr_id)->where('udc_status', '!=', 0)->get();
            return response()->json($userDocs);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    private function uploadUserDocument(Request $request, $fileInputName, $userId, $source, $docType)
    {
        if ($request->hasFile($fileInputName)) {

            $file = $request->file($fileInputName);
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/uploads/documents'), $fileName);
            $userDocument = new UserDocuments();
            $userDocument->udc_name = $fileName;
            $userDocument->udc_user_id = $userId;
            $userDocument->udc_source = $source;
            $userDocument->udc_doc_type = $docType;
            $userDocument->save();
        }
    }

    public function userDocsUpload(Request $request)
    {
        $request->validate([
            'doc_type' => 'required|numeric',
            'doc_name' => 'required|file'
        ], [
            'doc_type.required' => 'Something went wrong please reload the page and try again!',
            'doc_type.numeric' => 'Something went wrong please reload the page and try again!',
            'doc_name.required' => 'Please upload required document before proceed!',
            'doc_name.file' => 'Invalid file provided!'
        ]);
        try {
            $user = WebUser::find(Session::get('uid'));
            $docStatus = [1, 2];
            $checkOldDoc = UserDocuments::where('udc_user_id', '=', $user->usr_id)->where('udc_doc_type', '=', $request->doc_type)->whereIn('udc_status', $docStatus)->first();
            // dd($checkOldDoc);
            if ($checkOldDoc) {
                return redirect()->back()->with('error', 'Document is already uploaded!');
            }
            else {
                $this->uploadUserDocument($request, 'doc_name', $user->usr_id, 'User Document Page', $request->doc_type);
                return redirect()->back()->with('success', 'Document uploaded successfully!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveUserBankData(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'user_pan' => 'required|max:10|min:10',
            'user_name_in_bank' => 'required',
            'user_bank_name' => 'required_without:user_bank_name_other',
            'user_bank_name_other' => 'required_without:user_bank_name',
            'user_bank_acc' => 'required|numeric',
            'user_bank_acc_re' => 'required|same:user_bank_acc',
            'user_ifsc' => 'required|max:11|min:11',
            'user_bank_proof' => 'required|file|max:10240'
        ], [
            'user_name.required' => 'The user name is required.',
            'user_pan.required' => 'The PAN number is required.',
            'user_pan.max' => 'The PAN number must be exactly 10 characters.',
            'user_pan.min' => 'The PAN number must be exactly 10 characters.',
            'user_name_in_bank.required' => 'The name of the account holder is required.',
            'user_bank_name.required_without' => 'The bank name is required if "Other Bank Name" is not provided.',
            'user_bank_name_other.required_without' => 'The "Other Bank Name" field is required if the main bank name is not provided.',
            'user_bank_acc.required' => 'The bank account number is required.',
            'user_bank_acc.numeric' => 'The bank account number must be numeric.',
            'user_bank_acc_re.required' => 'Please confirm your bank account number.',
            'user_bank_acc_re.same' => 'The bank account confirmation does not match the account number.',
            'user_ifsc.required' => 'The IFSC code is required.',
            'user_ifsc.max' => 'The IFSC code must be exactly 11 characters.',
            'user_ifsc.min' => 'The IFSC code must be exactly 11 characters.',
            'user_bank_proof.required' => 'A bank proof document is required.',
            'user_bank_proof.file' => 'The bank proof must be a valid file.',
            'user_bank_proof.max' => 'The bank proof must not exceed 10 MB.'
        ]);
        try {
            $user = WebUser::find(Session::get('uid'));
            if (!$user)
                $this->revokeUserAccess();
            else {
                if (UserBankDetail::where('ubd_usr_id', '=', $user->usr_id)->where('ubd_user_kyc_status', '!=', 0)->exists()) {
                    $userBankDetail = UserBankDetail::where('ubd_usr_id', '=', $user->usr_id)->where('ubd_user_kyc_status', '!=', 0)->first();
                }
                else {
                    $userBankDetail = new UserBankDetail();
                }
                $userBankDetail->ubd_usr_id = Session::get('uid');
                $userBankDetail->ubd_user_name = $request->user_name;
                $userBankDetail->ubd_user_pan = $request->user_pan;
                $userBankDetail->ubd_user_name_in_bank = $request->user_name_in_bank;
                $userBankDetail->ubd_user_bank_name = $request->user_bank_name;
                $userBankDetail->ubd_user_bank_name_other = $request->user_bank_name_other;
                $userBankDetail->ubd_user_bank_acc = $request->user_bank_acc;
                $userBankDetail->ubd_user_ifsc = $request->user_ifsc;
                $userBankDetail->ubd_user_kyc_status = 3;
                if ($request->hasFile('user_bank_proof')) {
                    $file = $request->file('user_bank_proof');
                    $fileName = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('assets/uploads/documents'), $fileName);
                    $userBankDetail->ubd_user_bank_proof = $fileName;
                }
                else {
                    return redirect()->back()->with('error', 'Please upload bank proof!');
                }
                if ($userBankDetail->save()) {
                    return redirect()->back()->with('success', 'Bank Record Updated!');
                }
                else {
                    return redirect()->back()->with('error', 'Something went wrong! Please try again later!');
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewUserInvoiceCommand(Request $request)
    {
        $request->validate([
            'uid' => 'required|numeric',
            'inv_id' => 'required|numeric'
        ], [
            'uid.required' => 'Something went wrong. Please try again later!',
            'uid.numeric' => 'Something went wrong. Please try again later!',
            'inv_id.required' => 'Something went wrong. Please try again later!',
            'inv_id.numeric' => 'Something went wrong. Please try again later!'
        ]);
        try {
            $user = WebUser::find($request->uid);
            $services = CompanyService::get();
            $invoice = Invoice::find($request->inv_id);
            $company = CompanyInfo::find(1);
            $invoiceSettings = InvoiceSetting::find(1);
            if (($user && $user->usr_profile_status != 0) && ($invoice && $invoice->inv_status != 0) && ($company && $company->cmp_status != 0) && $invoiceSettings) {
                $invoiceDescriptions = InvoiceDescriptionAmount::where('ida_inv_no', '=', $invoice->inv_number)->where('ida_status', '!=', 0)->get();
                return view('User.invoiceLayout1', compact('user', 'invoice', 'invoiceDescriptions', 'company', 'invoiceSettings', 'services'));
            }
            else {
                return redirect()->back()->with('error', 'Ssomething went wrong. Please try after sometimes!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewApprovalLetter()
    {
        $user = WebUser::find(Session::get('uid'));
        $companyInfos = CompanyInfo::find(1);
        $aprovalSetting = ApprovalLetterSetting::find(1);
        $services = CompanyService::get();
        if ($user && $user->usr_verification_status == 1 && $companyInfos) {
            return view('User.approvalLetterLayout1', compact('user', 'companyInfos', 'aprovalSetting', 'services'));
        }
        else {
            return redirect()->back()->with('error', 'Your file is not approved yet!');
        }
    }

    private function revokeUserAccess()
    {
        Session::flush();
        return redirect('/');
    }

    public function locationView()
    {
        $location = Location::where('loc_user_id', '=', Session::get('uid'))->where('loc_status', '!=', 0)->first();
        if ($location) {
            return view('User.header') . view('User.location', compact('location')) . view('User.footer');
        }
        else {
            return view('User.header') . view('User.location') . view('User.footer');
        }
    }

    public function saveUserGeoLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required'
        ], [
            'latitude.required' => 'Latitude is required!',
            'longitude.required' => 'Longitude is required!'
        ]);

        try {
            $oldLocation = Location::where('loc_user_id', '=', Session::get('uid'))->where('loc_status', '!=', 0)->first();
            if ($oldLocation) {
                $oldLocation->loc_latitude = $request->latitude;
                $oldLocation->loc_longitude = $request->longitude;
                if ($oldLocation->save()) {
                    Session::flash('location', 'Location updated successfully!');
                }
            }
            else {
                $saveLocation = Location::create([
                    'loc_user_id' => Session::get('uid'),
                    'loc_latitude' => $request->latitude,
                    'loc_longitude' => $request->longitude
                ]);
                if ($saveLocation) {
                    Session::flash('location', 'Location saved successfully!');
                }
            }
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function submitPaymentDetails(Request $request)
    {
        // Validate the request with custom error messages
        $request->validate([
            'tnx_id' => 'required|unique:user_transactions,tnx_id',
            'tnx_amt' => 'required|numeric',
            'tnx_mode' => 'required',
            'tnx_date' => 'required|date|before_or_equal:today',
            'tnx_proof' => 'required|mimes:jpeg,jpg,png|max:2048'
        ], [
            'tnx_id.required' => 'Transaction ID is required!',
            'tnx_id.unique' => 'This Transaction ID already exists!',
            'tnx_amt.required' => 'Transaction amount is required!',
            'tnx_amt.numeric' => 'Transaction amount must be a number!',
            'tnx_mode.required' => 'Payment mode is required!',
            'tnx_date.required' => 'Transaction date is required!',
            'tnx_date.before_or_equal' => 'Transaction date cannot be in the future!',
            'tnx_proof.required' => 'Payment proof (screenshot) is required!',
            'tnx_proof.mimes' => 'Payment proof must be a file of type: jpeg, jpg, png!',
            'tnx_proof.max' => 'Payment proof file size cannot exceed 2MB!'
        ]);

        try {
            UserTransaction::create([
                'tnx_user_id' => Session::get('uid'),
                'tnx_id' => $request->tnx_id,
                'tnx_amt' => $request->tnx_amt,
                'tnx_mode' => $request->tnx_mode,
                'tnx_date' => $request->tnx_date,
                'tnx_proof' => $request->file('tnx_proof')->store('transaction/proofs', 'public'),
            ]);
            return redirect()->back()->with('success', 'Payment details submitted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit payment details: ' . $e->getMessage());
        }
    }
}
