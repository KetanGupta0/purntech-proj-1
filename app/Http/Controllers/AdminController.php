<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ApprovalLetterSetting;
use App\Models\CompanyInfo;
use App\Models\Invoice;
use App\Models\InvoiceDescriptionAmount;
use App\Models\CompanyService;
use App\Models\InvoiceSetting;
use App\Models\UserBankDetail;
use App\Models\UserDocuments;
use App\Models\WebUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function adminLoginView()
    {
        return view('header') . view('Admin.login') . view('footer');
    }

    public function adminDashboardView()
    {
        $company = CompanyInfo::find(1);
        if($company){
            return view('Admin.header') . view('Admin.dashboard',compact('company')) . view('Admin.footer');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }
    public function userProfileView()
    {
        $data = WebUser::where('usr_profile_status', '!=', 0)->orderBy('created_at','DESC')->get();
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
                ->where('web_users.usr_profile_status','!=',0)
                ->orderBy('web_users.created_at','DESC')
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
        try{
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
                ->where('web_users.usr_profile_status','!=',0)
                ->orderBy('web_users.created_at','DESC')
                ->get();
            // dd($results);
            return view('Admin.header') . view('Admin.user_bank_details',compact('results')) . view('Admin.footer');
        }catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function userInvoicesPageView()
    {
        $data = WebUser::where('usr_profile_status', '!=', 0)->orderBy('created_at','DESC')->get();
        return view('Admin.header') . view('Admin.user_invoices_page',compact('data')) . view('Admin.footer');
    }
    public function userDownloadView()
    {
        return view('Admin.header') . view('Admin.user_download_page') . view('Admin.footer');
    }
    public function adminProfileView()
    {
        return view('Admin.header') . view('Admin.admin_profile') . view('Admin.footer');
    }
    public function adminSettingsView()
    {
        try{
            $companyInfo = CompanyInfo::where('cmp_id','=',1)->where('cmp_status','=',1)->first();
            $approvalInfo = ApprovalLetterSetting::where('als_id','=',1)->where('als_status','=',1)->first();
            $invoiceInfo = InvoiceSetting::where('ins_id','=',1)->where('ins_status','=',1)->first();
            $admin = Admin::find(Session::get('uid'));
            // dd($approvalInfo);
            return view('Admin.header') . view('Admin.admin_settings',compact('companyInfo','approvalInfo','invoiceInfo','admin')) . view('Admin.footer');
        }catch (Exception $e) {
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
            } else {
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
            } else {
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
            } else {
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
            if($request->uid =="" || $request->uid == null) {
                return redirect('/')->with('error','Soemthing went wrong!');
            }else{
                $user = WebUser::find($request->uid);
                if($user){
                    $user->usr_first_name = $request->usr_first_name;
                    $user->usr_last_name = $request->usr_last_name;
                    $user->usr_email = $request->usr_email;
                    $user->usr_mobile = $request->usr_mobile;
                    $user->usr_alt_mobile = $request->usr_alt_mobile;
                    $user->usr_dob = date('Y/m/d', strtotime($request->usr_dob));
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
                        return view('Admin.gotouserViewPage',['uid'=>$user->usr_id,'code'=>200,'msg'=>'Profile data updated!']);
                    } else {
                        return view('Admin.gotouserViewPage',['uid'=>$user->usr_id,'code'=>400,'msg'=>'Something went worng!']);
                    }
                }else{
                    return view('Admin.gotouserViewPage',['uid'=>$user->usr_id,'code'=>400,'msg'=>'Something went worng!']);
                }
            }
        } catch (Exception $e) {
            return view('Admin.gotouserViewPage',['uid'=>$user->usr_id,'code'=>400,'msg'=>$e->getMessage()]);
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
            $services = CompanyService::orderBy('cms_service_name','ASC')->get();
            if ($user && $services) {
                return view('Admin.header') . view('Admin.view_user', compact('user','services')) . view('Admin.footer');
            } else {
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
            } else {
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
                $data = UserDocuments::where('udc_user_id','=',$user->usr_id)->where('udc_status','!=','0')->orderBy('udc_doc_type','ASC')->get();
                return view('Admin.header') . view('Admin.verify_documents', compact('data','user')) . view('Admin.footer');
            } else {
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
            } else {
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
                    // Check if all required document types are verified
                    $requiredDocumentTypes = [1, 2, 3, 4, 7];
                    $verifiedDocumentsCount = UserDocuments::where('udc_user_id', $user->usr_id)
                        ->whereIn('udc_doc_type', $requiredDocumentTypes)
                        ->where('udc_status', 2)
                        ->count();
                    // Update user verification status
                    if ($verifiedDocumentsCount == count($requiredDocumentTypes)) {
                        $user->usr_verification_status = 1; // Fully verified
                    } else {
                        $user->usr_verification_status = 0; // Not fully verified
                    }
                    $user->save();

                    // Return success view
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status' => true]);
                } else {
                    // Failed to save document status
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status' => false]);
                }
            } else {
                // User or document not found
                return view('Admin.goToVerifyDocuments', ['uid' => $request->uid, 'status' => false]);
            }
        } catch (Exception $e) {
            // Log the exception for debugging
            Log::error('Error verifying document: '.$e->getMessage());

            // Return failure view
            return view('Admin.goToVerifyDocuments', ['uid' => $request->uid, 'status' => false]);
        }
    }

    public function rejectNowDocumentCommand(Request $request){
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
                if($doc->save()){
                    // Check if all required document types are verified
                    $requiredDocumentTypes = [1, 2, 3, 4, 7];
                    $verifiedDocumentsCount = UserDocuments::where('udc_user_id', $user->usr_id)
                        ->whereIn('udc_doc_type', $requiredDocumentTypes)
                        ->where('udc_status', 2)
                        ->count();
                    // Update user verification status
                    if ($verifiedDocumentsCount == count($requiredDocumentTypes)) {
                        $user->usr_verification_status = 1; // Fully verified
                    } else {
                        $user->usr_verification_status = 0; // Not fully verified
                    }
                    $user->save();

                    // Return success view
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id, 'status' => true]);
                }else{
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id,'status1'=>false]);
                }
            } else {
                return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id,'status1'=>false]);
            }
        } catch (Exception $e) {
            return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id,'status1'=>false]);
        }
    }
    public function deleteNowDocumentCommand(Request $request){
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
                if($doc->save()){
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id,'status1'=>true]);
                }else{
                    return view('Admin.goToVerifyDocuments', ['uid' => $user->usr_id,'status1'=>false]);
                }
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewUserBankDetailsCommand(Request $request){
        $request->validate([
            'uid' => 'required|numeric'
        ],[
            'uid.required' => 'Unable to process your request right now!',
            'uid.numeric' => 'Unable to process your request right now!'
        ]);
        try{
            $user = WebUser::find($request->uid);
            $bankDetails = UserBankDetail::where('ubd_usr_id','=',$request->uid)->where('ubd_user_kyc_status','!=',0)->first();
            if ($user && $bankDetails) {
                return view('Admin.header') . view('Admin.user_bank_details_view',compact('user','bankDetails')) . view('Admin.footer');
            }else{
                return redirect()->back()->with('error','Details not updated!');
            }
        }catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateUserBankDetailsKYCCommand(Request $request){
        try{
            $req = $request->ubd_user_kyc_status;
            if($req == ""){
                return view('Admin.goToUserBankDetails',['code' => 404, 'uid' => $request->uid]);
            }
            if(!is_numeric($req)){
                return view('Admin.goToUserBankDetails',['code' => 400, 'uid' => $request->uid]);
            }
            if($req >= 1 && $req <= 4){
                $user = WebUser::find($request->uid);
                $bankDetails = UserBankDetail::find($request->ubdid);
                if($user && $bankDetails){
                    $bankDetails->ubd_user_kyc_status = $request->ubd_user_kyc_status;
                    if($bankDetails->save()){
                        return view('Admin.goToUserBankDetails',['code' => 402, 'uid' => $request->uid]);
                    }else{
                        return view('Admin.goToUserBankDetails',['code' => 400, 'uid' => $request->uid]);
                    }
                }else{
                    return view('Admin.goToUserBankDetails',['code' => 400, 'uid' => $request->uid]);
                }
            }else{
                return view('Admin.goToUserBankDetails',['code' => 400, 'uid' => $request->uid]);
            }
        }catch(Exception $e){
            return view('Admin.goToUserBankDetails',['code' => 405, 'uid' => $request->uid, 'msg' => $e->getMessage()]);
        }
    }

    public function raiseNewInvoiceCommand(Request $request){
        $request->validate([
            'uid' => 'required|numeric'
        ],[
            'uid.required' => 'Something went wrong. Please try again later!',
            'uid.numeric' => 'Something went wrong. Please try again later!'
        ]);
        try{
            $user = WebUser::find($request->uid);
            if($user){
                return view('Admin.header').view('Admin.newInvoice',compact('user')).view('Admin.footer');
            }
        }catch(Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }

    public function viewUserInvoiceList(Request $request){
        $request->validate([
            'uid' => 'required|numeric'
        ],[
            'uid.required' => 'Something went wrong. Please try again later!',
            'uid.numeric' => 'Something went wrong. Please try again later!'
        ]);
        try{
            $user = WebUser::find($request->uid);
            if($user){
                $invoiceList = Invoice::where('inv_party_id','=',$user->usr_id)->where('inv_status','!=',0)->get();
                return view('Admin.header').view('Admin.viewInvoiceList',compact('user','invoiceList')).view('Admin.footer');
            }
        }catch(Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }

    private function changeInvoiceStatus($uid,$inv_id,$status){
        $user = WebUser::find($uid);
        if($user){
            $invoice = Invoice::where('inv_id','=',$inv_id)->where('inv_party_id','=',$user->usr_id)->where('inv_status','!=',0)->first();
            if($invoice){
                $invoice->inv_status = $status;
                if($invoice->save()){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function makeInvoicePaidCommand(Request $request){
        try{
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if($uid == 0 || $inv_id == 0){
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }else{
                if($this->changeInvoiceStatus($uid,$inv_id,5)){
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }else{
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        }catch(Exception $e){
            return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoicePendingCommand(Request $request){
        try{
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if($uid == 0 || $inv_id == 0){
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }else{
                if($this->changeInvoiceStatus($uid,$inv_id,4)){
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }else{
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        }catch(Exception $e){
            return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoicePartialPaidCommand(Request $request){
        try{
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if($uid == 0 || $inv_id == 0){
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }else{
                if($this->changeInvoiceStatus($uid,$inv_id,2)){
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }else{
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        }catch(Exception $e){
            return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoiceRefundedCommand(Request $request){
        try{
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if($uid == 0 || $inv_id == 0){
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }else{
                if($this->changeInvoiceStatus($uid,$inv_id,3)){
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }else{
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        }catch(Exception $e){
            return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoiceUnpaidCommand(Request $request){
        try{
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if($uid == 0 || $inv_id == 0){
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }else{
                if($this->changeInvoiceStatus($uid,$inv_id,1)){
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 200, 'msg' => 'Invoice status updated successfully']);
                }else{
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        }catch(Exception $e){
            return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }
    public function makeInvoiceDeleteCommand(Request $request){
        try{
            $uid = $request->uid ?? 0;
            $inv_id = $request->inv_id ?? 0;
            if($uid == 0 || $inv_id == 0){
                return redirect()->to('/')->with(['error' => 'Something went wrong. Please try again later!']);
            }else{
                if($this->changeInvoiceStatus($uid,$inv_id,0)){
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 200, 'msg' => 'Invoice deleted successfully']);
                }else{
                    return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => 'Something went wrong. Please try again later!']);
                }
            }
        }catch(Exception $e){
            return view('Admin.goToInvoiceListPage',['uid' => $uid, 'code' => 400, 'msg' => $e->getMessage()]);
        }
    }

    public function raiseNewInvoiceFormSubmitCommand(Request $request){
        try{
            $uid = $request->uid ?? 0;
            $inv_date_input = $request->inv_date;
            $due_date_input = $request->due_date;
            $customer_name = $request->customer_name;
            $customer_phone1 = $request->customer_phone1;
            $customer_phone2 = $request->customer_phone2;
            $customer_address1 = $request->customer_address1;
            $customer_address2 = $request->customer_address2;

            if($uid == 0){
                return redirect()->to('/admin/user-invoices-page')->with(['error' => 'Something went wrong. Please try again later!']);
            }

            if($inv_date_input == ''){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Invoice date is required!']);
            }
            if($due_date_input == ''){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Due date is required!']);
            }
            if ($due_date_input < $inv_date_input) {
                return view('Admin.goToRaiseNewInvoice', ['uid'=>$uid, 'code' => 400, 'msg'=> 'Due date cannot be earlier than invoice date!']);
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

            if($customer_name == ''){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Name is required!']);
            }

            if($customer_phone1 == ''){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Phone 1 is required!']);
            }elseif(!is_numeric($customer_phone1) || strlen($customer_phone1) != 10){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Invalid phone 1 provided!']);
            }

            if($customer_phone2 != ''){
                if(!is_numeric($customer_phone2) || strlen($customer_phone2) != 10){
                    return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Invalid phone 2 provided!']);
                }
            }

            if($customer_address1 == ''){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Address Line 1 is required!']);
            }
            if($customer_address2 == ''){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Address Line 2 is required!']);
            }

            $user = WebUser::find($uid);
            $invoice_number = $user->usr_username;

            $countInvoice = Invoice::where('inv_status','!=',0)->count();
            $invoice_number = $invoice_number.'/IN'.($countInvoice+1);

            $inv_amount = 0.00;
            foreach ($request->inv_amount as $amount) {
                if($amount == '' || $amount == null){
                    continue;
                }elseif (!is_numeric($amount) || $amount <= 0) {
                    return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Invalid amount provided!']);
                }
                $inv_amount += (float)$amount;
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
            if(!$invoice->save()){
                return view('Admin.goToRaiseNewInvoice',['uid'=>$uid, 'code' => 400, 'msg'=> 'Something went wrong while saving invoice. Please try again after sometimes!']);
            }else{
                $string = $invoice_number;
                // Explode the string by slashes
                $parts = explode('/', $string);
                // Get the last two parts and join them into a single string
                $lastTwoParts = implode('/', array_slice($parts, -2));

                $optMessage ="Dear Customer, Your ".$lastTwoParts." INR ".$inv_amount." fee at BHRTIWEB is due for processing, Please make sure to clear your dues immediately to avid file closure. BHRTIWEB";
                
                $response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=Pnb@2019&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $customer_phone1 . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162513430583099');
                Log::info('SMS API Response', ['status' => $response->status(), 'body' => $response->body()]);

                if (count($request->inv_desc_title) !== count($request->inv_amount)) {
                    return view('Admin.goToRaiseNewInvoice', ['uid' => $uid, 'code' => 400, 'msg' => 'Mismatch between descriptions and amounts!']);
                }
                foreach($request->inv_desc_title as $key=>$description){
                    $invoiceDescription = new InvoiceDescriptionAmount();
                    if($description == "" || $description == null){
                        continue;
                    }else{
                        $invoiceDescription->ida_inv_id = $invoice->inv_id;
                        $invoiceDescription->ida_inv_no = $invoice_number;
                        $invoiceDescription->ida_description = $description;
                        $invoiceDescription->ida_amount = $request->inv_amount[$key];
                        $invoiceDescription->save();
                    }
                }
                

                return view('Admin.goToRaiseNewInvoice',['uid' => $uid, 'code'=> 200, 'msg'=> 'Invoice Raised Successfully']);

            }
        }catch(Exception $e){
            if($uid == 0){
                return redirect()->to('/admin/user-invoices-page')->with(['error' => $e->getMessage()]);
            }
            return view('Admin.goToRaiseNewInvoice',['uid' => $uid, 'code' => 400, 'msg'=> $e->getMessage()]);
        }
    }

    public function updateCompanyCommand(Request $request){
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
        try{
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
            $companyInfo->cmp_logo = $request->cmp_logo;
            if ($request->hasFile('cmp_logo')) {
                $file = $request->file('cmp_logo');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('assets/img/uploads/logos'), $fileName);
                $companyInfo->cmp_logo = $fileName;
            }
            if($companyInfo->save()){
                return redirect()->back()->with('success', 'Company information updated successfully!');
            }else{
                return redirect()->back()->with('error', 'Something went wrong. Please try again later!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateApprovalLetterCommand(Request $request){
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
        try{
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
            if($approvalSetting->save()){
                return redirect()->back()->with('success','Approval letter settings updated successfully');
            }else{
                return redirect()->back()->with('error','Something went wrong. Please try again later!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateInvoiceCommand(Request $request){
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
        try{
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
            if($invoiceSetting->save()){
                return redirect()->back()->with('success','Invoice settings updated successfully!');
            }else{
                return redirect()->back()->with('error','Something went wrong. Please try again later!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateAdminAccountCommand(Request $request){
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
        
        try{
            $admin = Admin::find(Session::get('uid'));
            if($admin && Hash::check($request->adm_current_password,$admin->adm_password)){
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
                if($request->adm_new_password != '' && $request->adm_new_password != null){
                    $admin->adm_password = Hash::make($request->adm_new_password);
                    $admin->adm_visible_password = $request->adm_new_password;
                }
                if($admin->save()){
                    return redirect()->back()->with('success','Account details updated successfully!');
                }else{
                    return redirect()->back()->with('error','Something went wrong. Please try again later!');
                }
            }else{
                return redirect()->back()->with('error','Current password is wrong!');
            }
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getCompanyInfo(){
        $company = CompanyInfo::find(1);
        return response()->json($company);
    }
    public function makeFirstAdmin()
    {
        $adm_first_name = "Super";
        $adm_last_name = "Admin";
        $adm_email = "admin@gmail.com";
        $adm_mobile = "1234567890";
        $adm_username = "SA16092024";
        $adm_visible_password = "demo";

        $admin = new Admin();
        $adm_password = Hash::make($adm_visible_password);
        $admin->adm_first_name = $adm_first_name;
        $admin->adm_last_name = $adm_last_name;
        $admin->adm_email = $adm_email;
        $admin->adm_mobile = $adm_mobile;
        $admin->adm_username = $adm_username;
        $admin->adm_password = $adm_password;
        $admin->adm_visible_password = $adm_visible_password;
        if ($admin->save()) {
            echo "Admin Created Email -> " . $adm_email . " | Password -> " . $adm_visible_password;
        } else {
            echo "Something went wrong!";
        }
    }
}
