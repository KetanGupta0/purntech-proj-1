<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\UserBankDetail;
use App\Models\UserDocuments;
use App\Models\WebUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function adminLoginView()
    {
        return view('header') . view('Admin.login') . view('footer');
    }

    public function adminDashboardView()
    {
        return view('Admin.header') . view('Admin.dashboard') . view('Admin.footer');
    }
    public function userProfileView()
    {
        $data = WebUser::where('usr_profile_status', '!=', 0)->get();
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
                ->get();
            // dd($results);
            return view('Admin.header') . view('Admin.user_bank_details',compact('results')) . view('Admin.footer');
        }catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function userInvoicesPageView()
    {
        return view('Admin.header') . view('Admin.user_invoices_page') . view('Admin.footer');
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
        return view('Admin.header') . view('Admin.admin_settings') . view('Admin.footer');
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
            if ($user) {
                return view('Admin.header') . view('Admin.view_user', compact('user')) . view('Admin.footer');
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
    public function verifyNowDocumentCommand(Request $request){
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
                $doc->udc_status = 2;
                if($doc->save()){
                    return view('Admin.goToVerifyDocuments', ['uid' => 1,'status'=>true]);
                }else{
                    return view('Admin.goToVerifyDocuments', ['uid' => 1,'status'=>false]);
                }
            } else {
                return view('Admin.goToVerifyDocuments', ['uid' => 1,'status'=>false]);
            }
        } catch (Exception $e) {
            return view('Admin.goToVerifyDocuments', ['uid' => 1,'status'=>false]);
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
                    return view('Admin.goToVerifyDocuments', ['uid' => 1,'status1'=>true]);
                }else{
                    return view('Admin.goToVerifyDocuments', ['uid' => 1,'status1'=>false]);
                }
            } else {
                return view('Admin.goToVerifyDocuments', ['uid' => 1,'status1'=>false]);
            }
        } catch (Exception $e) {
            return view('Admin.goToVerifyDocuments', ['uid' => 1,'status1'=>false]);
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
                    return view('Admin.goToVerifyDocuments', ['uid' => 1,'status1'=>true]);
                }else{
                    return view('Admin.goToVerifyDocuments', ['uid' => 1,'status1'=>false]);
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
            echo "Admin Created Username -> " . $adm_username . " | Password -> " . $adm_visible_password;
        } else {
            echo "Something went wrong!";
        }
    }
}
