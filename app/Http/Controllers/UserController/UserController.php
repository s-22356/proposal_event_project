<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProposeUser;
use Illuminate\Support\Facades\Cookie;

use DB;
use Session;
use Exception;
use Carbon\Carbon;

class UserController extends Controller
{
    public function showHome(){
        return view('pages.user.homepage', [
            'module' => 'page',
            'active-page' => 'home',
        ]);
    }

    public function createId(){
        return view('pages.user.sign_up', [
            'module' => 'page',
            'active-page' => 'home',
        ]);
    }

    public function GenerateOtp(Request $request){
        /*dd($request->all());*/
        $now    =   date('Y-m-d H:i:s');
        $mobile_no              =   $request->mobile_no;
        $random                 =   $request->random;
        $decrypted_mobile_no    =   decryptHEXFormat($mobile_no,$random);
        $enc_mobile             =   encryptProposerPhNO($decrypted_mobile_no);
        
        $phone_exists   =   DB::table('tbl_propose_user')->where('p_user_phone', $enc_mobile)->exists();
        DB::beginTransaction();
        try{
            if(!$phone_exists){
                $token  =   md5($now . get_client_ip() . rand(100000, 999999));
                $user_register_data =   array(
                    'p_user_token'  =>  $token,
                    'p_user_phone'  =>  $enc_mobile,
                    'is_profile'    =>  1,
                    'is_active'     =>  1,
                    'created_at'    => $now
                );
                DB::table('tbl_propose_user')->insert($user_register_data);
                DB::commit();
                $reponse = array(
                    'error'     =>  false,
                    'message'   =>  "Your Profile is register."
                );
                return response(json_encode($reponse), 200);
            }else{
                $reponse = array(
                    'error'     =>  true,
                    'message'   =>  "Your Profile is already registered.Please login."
                );
                return response(json_encode($reponse), 200);
            }
            
        }catch(Exception $e){
            DB::rollback();
                $reponse = array(
                    'error'     =>  true,
                    'message'   =>  "Unable to register the profile"
                );
            return response(json_encode($reponse), 200);
        }
            

    }

    public function Generatesecretcode(Request $request){
        /*dd($request->all());*/
        $Login_mobile_no    =   $request->Login_mobile_no;
        $decrypted_login_mobile_no  =   decryptHEXFormat($Login_mobile_no, $request->random);
        DB::beginTransaction();
        try{
            $check_profile  =   ProposeUser::where('p_user_phone', encryptProposerPhNO($decrypted_login_mobile_no))->get();
            if(!$check_profile->isEmpty()){
                $OTP  = generateOTP();
                $last_profil = DB::table('tbl_propose_user')->where('p_uid', $check_profile[0]["p_uid"])->update(
                    array('p_user_key'   =>  $OTP)
                );
                DB::commit();
                $reponse = array(
                    'error'     =>  false,
                    'token'     =>  $check_profile[0]["p_user_token"],
                    'secret_key'=>  $OTP,
                    'message'   =>  "Please provide the secrectkey to login."
                );
                return response(json_encode($reponse), 200);
            }else{
                $reponse = array(
                    'error'     =>  true,
                    'message'   =>  "Profile not found."
                );
                return response(json_encode($reponse), 200);
            }
        }catch(Exception $e){
            DB::rollback();
                $reponse = array(
                    'error'     =>  true,
                    'message'   =>  "Unable to process."
                );
            return response(json_encode($reponse), 200);
        }
    }

    public function contactus(){
        return view('pages.user.contact', [
            'module' => 'page',
            'active-page' => 'home',
        ]);
    }

    public function aboutus(){
        return view('pages.user.aboutus', [
            'module' => 'page',
            'active-page' => 'home',
        ]);
    }
    public function logInPage(){
        return view('pages.user.sign_in', [
            'module' => 'page',
            'active-page' => 'home',
        ]);
    }
    
    public function ProposalEvents(){
        
        return view('pages.user.events',[
            'module' => 'page',
            'active-page' => 'home',
        ]);
    }

    public function ProposalBookEvents(Request $request){
        /*dd($request->all());*/
        $now    =   date('Y-m-d H:i:s');
        $package_id     =   $request->package_id;
        $login_token    =   $request->login_token;
        $package_id_exists  =   DB::table('tbl_propose_category')->where('pc_id',$package_id)->get();
        $login_token_exists =   DB::table('tbl_propose_user')->where('p_user_token',$login_token)->get();

        if($package_id_exists->isEmpty()){
            $reponse = array(
                'error'     =>  true,
                'message'   =>  "Package doesn't exists."
            );
            return response(json_encode($reponse), 200);
        }elseif($login_token_exists->isEmpty()){
            $reponse = array(
                'error'     =>  true,
                'message'   =>  "Login token doesn't match."
            );
            return response(json_encode($reponse), 200);
        }else{
            DB::beginTransaction();
            try{
                
                $data   =   array(
                    'pe_user_phone'         =>  $login_token_exists[0]->p_user_phone,
                    'pe_amount'             =>  $package_id_exists[0]->pc_pay_amount,
                    'created_at'            =>  $now,
                    'propose_user_id'       =>  $login_token_exists[0]->p_uid,
                    'propose_category_id'   =>  $package_id_exists[0]->pc_id
                );
                
                DB::table('tbl_proposal_events')->insert($data);
                DB::commit();
                $reponse = array(
                    'error'     =>  false,
                    'message'   =>  "Successfully Added Your ".$package_id_exists[0]->pc_plan_name." Event.We will contact you shortly."
                );
                return response(json_encode($reponse), 200);

            }catch(Exception $e){
                DB::rollback();
                $reponse = array(
                    'error'     =>  true,
                    'message'   =>  "something went wrong!!Please try again."
                );
                return response(json_encode($reponse), 200);
            }
        }
    }
    public function VerifySecretCode(Request $request){
        /*dd((decryptHEXFormat($request->Login_mobile_no,$request->random)));*/
        $now    =   date('Y-m-d H:i:s');
        $expiry = date("Y-m-d H:i:s", strtotime('+30 minutes', strtotime($now)));
        $dec_ph_no   =   decryptHEXFormat($request->Login_mobile_no,$request->random);
        $secret_code =   $request->secret_key;
        $check_secret_code_against_prof =   ProposeUser::where('p_user_phone', encryptProposerPhNO($dec_ph_no))->first();
        /*dd( $check_secret_code_against_prof->count() > 0);*/
        DB::beginTransaction();
        try{
            if($check_secret_code_against_prof->count() > 0){
                
                if($check_secret_code_against_prof["p_user_key"] == $secret_code){
                    
                    ProposeUser::where('p_user_phone', encryptProposerPhNO($dec_ph_no))->update([
                        'p_user_token'      =>  md5($check_secret_code_against_prof["p_user_token"]),
                        'p_user_fullname'   =>  $request->fullname,
                        'login_at'          =>  $now,
                        'login_expired_on'  =>  $expiry
                    ]);
                    Session::put('login_token', md5($check_secret_code_against_prof["p_user_token"]));
                    Cookie::queue(Cookie::forever('Profile_name', $request->fullname));
                    DB::commit();
                    $reponse = array(
                        'error'         =>  false,
                        'profile_name'  =>  $request->fullname,
                        'login_time'    =>  $now,
                        'expired_on'    =>  $expiry,
                        'login_token'   =>  md5($check_secret_code_against_prof["p_user_token"]),
                        'message'       =>  "Profile Authenticated."
                    );
                    return response(json_encode($reponse), 200);
                }else{
                    $reponse = array(
                        'error'     =>  true,
                        'message'   =>  "Invalid OTP."
                    );
                    return response(json_encode($reponse), 200);
                }
            }else{
                $reponse = array(
                    'error'     =>  true,
                    'message'   =>  "Either mobile number is incorrect or profile is not registered."
                );
                return response(json_encode($reponse), 200);
            }
            
        }catch(Exception $e){
            DB::rollback();
            $reponse = array(
                'error'     =>  true,
                'message'   =>  "Something went wrong."
            );
            return response(json_encode($reponse), 200);
        }
    }

    public function logout(){
        if (!empty(Session::all())) {
            Session::flush();
            Cookie::queue(Cookie::forget('Profile_name'));
            $reponse = array(
                'error'     =>  false,
                'message'   =>  "You have Logged out."
            );
            return response(json_encode($reponse), 200);
        }else{
            $reponse = array(
                'error'     =>  true,
                'message'   =>  "Something Went Wrong."
            );
            return response(json_encode($reponse), 200);
        }
    }
}
