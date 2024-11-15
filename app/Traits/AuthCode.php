<?php namespace App\Traits;

use DB;
use Log;
use Auth;
use Mail;
use DateTime;
use Exception;
use Carbon\Carbon;
use App\Mail\Email;
use App\Models\Role;
use App\Models\User;
use App\Mail\OtpEmail;
use Twilio\Rest\Client;
use App\Mail\EnquiryMail;
use App\Models\Userdevice;
use App\Mail\PasswordReset;
use App\Mail\SendLoginDetail;
use App\Mail\VerifyEmailLink;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\{File, Storage};

trait AuthCode
{
    public function result($status = false, $data = [], $errors = [], $msg = '', $httpResponse = 200) {
        if (empty($data) && empty($errors)) {
            return response()->json(['status' => $status, 'message' => $msg, 'data' => []], $httpResponse);
        } elseif (empty($data) && !empty($errors)) {
            return response()->json(
                ['status' => $status, 'message' => $msg, 'data' => [], 'errors' => $errors],
                $httpResponse
            );
        } elseif (!empty($data) && empty($errors)) {
            return response()->json(['status' => $status, 'message' => $msg, 'data' => $data], $httpResponse);
        } else {
            return response()->json(
                ['status' => $status, 'message' => $msg, 'data' => $data, 'errors' => $errors],
                $httpResponse
            );
        }
    }
    public function deleteUserData($user) {
        $user_id = $user->id;
        // delete user otp
        if(!empty($user->user_otp)) {
            OtpVerification::where('user_id',$user->id)->delete();
        }
        // delete user token
        $user->tokens()->delete();
        // delete user device data
        if(!empty($user->user_device)) {
            Userdevice::where('user_id',$user->id)->delete();
        }
        // delete roles
        DB::table('role_user')->where('user_id',$user->id)->delete();
        // delete user
        $status = $user->delete();
        if($status) {
            return true;
        } else {
            return false;
        }
    }
    public function generateUniqueForgotToken(){
        do{
            $str = md5(uniqid(rand(), true));    
        }while(User::where('forgot_password_token', '=', $str)->count() > 0);
        return $str;
    }
    public function checkOtpExpire($datetime){
        $mytime = Carbon::now();
        $diff_in_hour = $mytime->diffInHours($datetime);
        if ($diff_in_hour > 1) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    
    }
    public function getUserRoleWithId($user) {
        if(!empty($user['roles'])) {
            $userRoles = $user['roles'];
            foreach($userRoles as $userRole) {
                $old_role[] = $userRole->id;
            }
            if($old_role > 0) {
                $roles = Role::select('id','name')->whereIn('id',$old_role)->get();
                return $roles;
            }
            return [];
        }
        return [];
    }
    public function sendEmailResetLink($data){
        Mail::to($data['email'])->send(new PasswordReset($data));
        return true;
    }
    public function sendEmailVerification($data){

        Mail::to($data['email'])->send(new OtpEmail($data));
        return true;
    }
    public function sendEmailVerificationLink($data){

        Mail::to($data['email'])->send(new VerifyEmailLink($data));
        return true;
    }
    public function sendAdminLoginDetail($data){

        Mail::to($data['email'])->send(new SendLoginDetail($data));
        return true;
    }
    public function sendEnquiryDetail($data){

        Mail::to($data['email'])->send(new EnquiryMail($data));
        return true;
    }
    public function sendMobileVerification($mobile, $message){
        
        $smsService = getenv("SMS_SERVICE");
        if($smsService == 'twilio') {
            $status  = $this->sendTwilioSms($mobile, $message);
        }
        return $status;
    }
    public function sendTwilioSms($mobile, $message) {
        $accountSid = getenv("TWILIO_SID");
        $authToken = getenv("TWILIO_TOKEN");
        $accountFrom = getenv("TWILIO_FROM");
        try {
            $client = new Client($accountSid, $authToken);
            $status = $client->messages
                ->create($mobile, // to
                    array(
                        "from" => $accountFrom,
                        "body" => $message
                    )
                );

        } catch (Exception $e) {
            $status = "Error: " . $e->getMessage();
        }
    }
    public function uploadImg($file, $path,$path_type='public')
    {
        $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        if($path_type == 'protected') {
            Storage::disk('protected')->put($path.'/'.$filename, File::get($file));
        } else {
            Storage::disk($path)->put($filename, File::get($file));
        }
        return $filename;
    }
    public function loginUser($username,$password,$loginType){
        /**
         * 0 => email
         * 1 => username
         * 2 => Mobile
         */
        $authAttemptArr=[];
        if($loginType == 0){
            $authAttemptArr = [
                "email"=>$username,
            ];
        }else if($loginType == 1){
            $authAttemptArr = [
                "username"=>$username,
            ];
        }else if($loginType == 2){
            $authAttemptArr = [
                "mobile"=>$username,
            ];
        }
        $authAttemptArr['password'] = $password;
        if(Auth::attempt($authAttemptArr)){
            $user = Auth::user();
            return $user;
        }else{
            return false;
        }
    }
   

    public function sendMobileNotification($mobile, $message){
        
        $smsService = getenv("SMS_SERVICE");
        if($smsService == 'twilio') {
            $status  = $this->sendTwilioSms($mobile, $message);
        }
        return $status;
    }
}
?>