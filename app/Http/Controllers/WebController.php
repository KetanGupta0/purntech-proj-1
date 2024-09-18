<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\OtpRecord;
use App\Models\UserDocuments;
use App\Models\WebUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    /* Document Types Definition
    +--------------------------------------+
    | Code  - Document Type                |
    +--------------------------------------+
    | 1     - Aadhar Front                 |
    | 2     - Aadhar Back                  |
    | 3     - PAN Card                     |
    | 4     - Bank Passbook / Cancel Cheque|
    | 5     - Voter ID / Driving License   |
    | 6     - Land Doucments               |
    | 7     - Land Photographs             |
    | 8     - KYC Processing               |
    | 9     - KYC Rejected                 |
    | 10    - KYC Approved                 |
    | 11    - ETC                          |
    +--------------------------------------+
    */
    public function uploadUserDocument(Request $request, $fileInputName, $userId, $source)
    {
        if ($request->hasFile($fileInputName)) {
            $file = $request->file($fileInputName);
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/uploads/documents'), $fileName);
            $userDocument = new UserDocuments();
            $userDocument->udc_name = $fileName;
            $userDocument->udc_user_id = $userId;
            $userDocument->udc_source = $source;
            if($fileInputName == 'upload_aadhar_front')
                $userDocument->udc_doc_type = 1;
            elseif($fileInputName == "upload_aadhar_back"){
                $userDocument->udc_doc_type = 2;
            }elseif($fileInputName == "upload_pan_card"){
                $userDocument->udc_doc_type = 3;
            }
            $userDocument->save();
        }
    }

    public function verifyMobileAJAX(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10|numeric'
        ], [
            'mobile.required' => 'Mobile number is required!',
            'mobile.digits' => 'Mobile number must be 10 digits!',
            'mobile.numeric' => 'Please check your mobile number!'
        ]);
        try {
            $user = WebUser::where('usr_mobile', '=', $request->mobile)->where('usr_profile_status', '=', 1)->first();
            if ($user) {
                $otp = rand(111111, 999999);
                $optMessage = $otp . " is your OTP for BHRTI website login.OTP valid for 8 minutes.Do not share this OTP with anyone. FISBHT";
                //$response = Http::get('http://smsfortius.in/api/mt/SendSMS?user=amazepay&password=amazepay&senderid=FISBHT&channel=Trans&DCS=0&flashsms=0&number=91' . $request->mobile . '&text=' . $optMessage . '&route=14&peid=1001515190000051607&DLTTemplateId=1007162495816654996');
                $otpRecord = new OtpRecord();
                $otpRecord->otp_code = $otp;
                $otpRecord->otp_initiated_by = $user->usr_id;
                $otpRecord->otp_user_type = "User";
                $otpRecord->otp_initiated_for = "Login";
                $otpRecord->otp_sent_to = $request->mobile;
                $otpRecord->otp_message = $optMessage;
                $otpRecord->otp_expires_at = Carbon::now()->addMinutes(8); // here I want to add 8 minutes from the current time
                $otpRecord->save();
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } catch (Exception $ex) {
            return response()->json(['message', $ex->getMessage()], 400);
        }
    }

    public function matchOTPAJAX(Request $request) {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
            'mobile' => 'required|numeric|digits:10'
        ], [
            'otp.required' => 'OTP is required!',
            'otp.numeric' => 'Invalid OTP!',
            'otp.digits' => 'Invalid OTP!',
            'mobile.required' => 'Mobile number is required!',
            'mobile.numeric' => 'Invalid mobile number!',
            'mobile.digits' => 'Invalid mobile number!'
        ]);
    
        try {
            // Stage 1 - Verify User Status
            $user = WebUser::where('usr_mobile', $request->mobile)
                ->where('usr_profile_status','=', 1)
                ->first();
            
            if (!$user) {
                return response()->json(['message' => 'User not found!'], 404);
            }
    
            // Stage 2 - Check OTP is generated or not
            $otpRecord = otpRecord::where('otp_initiated_by', $user->usr_id)
                ->where('otp_user_type', 'User')
                ->where('otp_sent_to', $request->mobile)
                ->where('otp_code', $request->otp)
                ->where('otp_status','=',0)
                ->first();
            
            if (!$otpRecord) {
                return response()->json(['message' => 'Invalid OTP or OTP not found!'], 404);
            }
    
            // Stage 3 - Confirm OTP Expiration time
            $currentTime = Carbon::now();
            $maxAllowedTime = $otpRecord->otp_expires_at;
            $otpRecord->otp_status = 1;
            $otpRecord->save();
            if ($currentTime->lessThan($maxAllowedTime)) {
                Session::put('loggedin','user');
                Session::put('uid',$user->usr_id);
                Session::put('fusername',$user->usr_first_name);
                Session::put('lusername',$user->usr_last_name);
                return response()->json(true);
            } else {
                return response()->json(['message' => 'OTP has expired!'],400);
            }
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 400);
        }
    }
    

    public function enquiryFormSubmit(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10|numeric',
            'service' => 'required',
            'date' => 'required'
        ], [
            'first_name.required' => 'First name is required!',
            'last_name.required' => 'Last name is required!',
            'email.required' => 'Email name is required!',
            'email.email' => 'Please provide a valid email!',
            'mobile.required' => 'Mobile number is required!',
            'mobile.digits' => 'Mobile number must be 10 digits!',
            'mobile.numeric' => 'Please enter a valid mobile number!',
            'service.required' => 'Please choose a service!',
            'date.required' => 'Please pick a date!'
        ]);

        try {
            $uid=0;
            // Stage 1
            $enquiry = new Enquiry();
            $enquiry->enq_user_first_name = $request->first_name;
            $enquiry->enq_user_last_name = $request->last_name;
            $enquiry->enq_user_email = $request->email;
            $enquiry->enq_user_mobile = $request->mobile;
            $enquiry->enq_user_service = $request->service;
            $enquiry->enq_user_date = $request->date;

            if ($enquiry->save()) {
                // Stage 2
                $oldUser = WebUser::where('usr_email', '=', $request->email)->orWhere('usr_mobile', '=', $request->mobile)->where('usr_profile_status', '!=', 0)->first();
                if (!$oldUser) {
                    // Extract a part of the string
                    $part = substr($request->first_name, 0, 3); // Get the first 3 characters
                    $partUpper = strtoupper($part);

                    $username = $partUpper . rand(11111, 99999);
                    while (WebUser::where('usr_username', '=', $username)->first()) {
                        $username = $partUpper . rand(11111, 99999);
                    }

                    $user = new WebUser();
                    $user->usr_first_name = $request->first_name;
                    $user->usr_last_name = $request->last_name;
                    $user->usr_email = $request->email;
                    $user->usr_mobile = $request->mobile;
                    $user->usr_service = $request->service;
                    $user->usr_date = $request->date;
                    $user->usr_username = $username;
                    if (!$user->save()) {
                        return redirect()->back()->with([
                            'err_code' => 905, //Database Error Code
                            'message' => 'Problem while saving user info!'
                        ]);
                    }
                    $uid = $user->usr_id;
                }
            } else {
                return redirect()->back()->with([
                    'err_code' => 905, //Database Error Code
                    'message' => 'Problem while saving enquiry form!'
                ]);
            }

            $this->uploadUserDocument($request,"upload_aadhar_front",$uid,'Enquiry Form');
            $this->uploadUserDocument($request,"upload_aadhar_back",$uid,'Enquiry Form');
            $this->uploadUserDocument($request,"upload_pan_card",$uid,'Enquiry Form');

            return redirect()->back()->with([
                'status' => true,
                'message' => 'Form saved successfully!'
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->with([
                'err_code' => 900,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function getUserImageAJAX(){
        if(Session::has('loggedin')){
            if(Session::get('loggedin') == 'user'){
                $user = WebUser::find(Session::get('uid'));
                return response()->json($user->usr_profile_photo);
            }
        }
    }

    public function logout(){
        Session::flush();
        return redirect('/');
    }
}
