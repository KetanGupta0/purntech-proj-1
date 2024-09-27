<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Models\Invoice;
use App\Models\InvoiceDescriptionAmount;
use App\Models\UserBankDetail;
use App\Models\UserDocuments;
use App\Models\WebUser;
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
        return view('User.header') . view('User.dashboard') . view('User.footer');
    }
    public function profileView()
    {
        $user = WebUser::find(Session::get('uid'));
        return view('User.header') . view('User.profile', compact('user')) . view('User.footer');
    }
    public function documentsView()
    {
        return view('User.header') . view('User.documents') . view('User.footer');
    }
    public function invoicesView()
    {
        $data = Invoice::where('inv_party_id','=', Session::get('uid'))->where('inv_status','!=',0)->get();
        return view('User.header') . view('User.invoices',compact('data')) . view('User.footer');
    }
    public function bankDetailsView()
    {
        $data = UserBankDetail::where('ubd_usr_id','=',Session::get('uid'))->where('ubd_user_kyc_status','!=',0)->first();
        if($data){
            return view('User.header') . view('User.bank_details',compact('data')) . view('User.footer');
        }else{
            return view('User.header') . view('User.bank_details') . view('User.footer');
        }
    }
    public function paymentsView()
    {
        return view('User.header') . view('User.payments') . view('User.footer');
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
            $dateObject = DateTime::createFromFormat('d M, Y', $request->usr_dob);
            $user->usr_dob = $dateObject->format('Y-m-d');
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
            $userDocs = UserDocuments::where('udc_user_id', '=', $user->usr_id)->get();
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
            $checkOldDoc = UserDocuments::where('udc_doc_type', '=', $request->doc_type)->where('udc_status', '=', 1)->orWhere('udc_status', '=', 2)->first();
            if ($checkOldDoc) {
                return redirect()->back()->with('error', 'Document is already uploaded!');
            } else {
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
            if(!$user) $this->revokeUserAccess();
            else{
                if(UserBankDetail::where('ubd_usr_id','=',$user->usr_id)->where('ubd_user_kyc_status','!=', 0)->exists()){
                    $userBankDetail = UserBankDetail::where('ubd_usr_id','=',$user->usr_id)->where('ubd_user_kyc_status','!=', 0)->first();
                }else{
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
                }else{
                    return redirect()->back()->with('error', 'Please upload bank proof!');
                }
                if($userBankDetail->save()){
                    return redirect()->back()->with('success','Bank Record Updated!');
                }else{
                    return redirect()->back()->with('error','Something went wrong! Please try again later!');
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewUserInvoiceCommand(Request $request){
        $request->validate([
            'uid' => 'required|numeric',
            'inv_id' => 'required|numeric'
        ],[
            'uid.required' => 'Something went wrong. Please try again later!',
            'uid.numeric' => 'Something went wrong. Please try again later!',
            'inv_id.required' => 'Something went wrong. Please try again later!',
            'inv_id.numeric' => 'Something went wrong. Please try again later!'
        ]);
        try{
            $user = WebUser::find($request->uid);
            $invoice = Invoice::find($request->inv_id);
            $company = CompanyInfo::find(1);
            if(($user && $user->usr_profile_status != 0) && ($invoice && $invoice->inv_status != 0) && ($company && $company->cmp_status != 0)){
                $invoiceDescriptions = InvoiceDescriptionAmount::where('ida_inv_no','=',$invoice->inv_number)->where('ida_status','!=', 0)->get();
                return view('User.invoiceLayout1',compact('user','invoice', 'invoiceDescriptions','company'));
            }else{
                return redirect()->back()->with('error','Ssomething went wrong. Please try after sometimes!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function revokeUserAccess(){
        Session::flush();
        return redirect('/');
    }
}
