<?php

namespace App\Http\Controllers\PaymentController;

//use App\Helpers\CurrencyConverter;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe;
use App\Models\Payment;
use DB;
use Session;
use Exception;

class PaymentController extends Controller
{
    public function stripeCheckout(Request $request) {
        /*dd($request->all());*/
        $package_id     =   $request->package_id;
        $login_token    =   Session::get('login_token');
        $package_id_exists  =   DB::table('tbl_propose_category')->where('pc_id',$package_id)->get();
        $login_token_exists =   DB::table('tbl_propose_user')->where('p_user_token',$login_token)->get();
        Session::put('package_id', $package_id);

        if($package_id_exists->isEmpty()){

            return redirect()->back()
            ->with('message', 'error|Package doesnt exists.Please dont change package id from console.');  
            
        }elseif($login_token_exists->isEmpty()){

            return redirect('/log-in')
            ->with('message', 'error|Login token doesnt match.');  
            
        }else{
            $stripe =   new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $redirect_url   =   route('stripe.checkout.success').'?session_id={CHECKOUT_SESSION_ID}';
            
            $response = $stripe->checkout->sessions->create([
                'success_url' => $redirect_url,

                'customer_email' => 'demo@gmail.com',

                'payment_method_types' => ['card'],

                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => $request->product,
                            ],
                            'unit_amount' =>  100 * (int) convertCurrency('INR','USD',$request->price,env('CURRENCY_APP_ID')),
                            'currency' => 'USD',
                        ],
                        'quantity' => 1
                    ],
                ],

                'mode' => 'payment',
                'allow_promotion_codes' => true,
            ]);

            return redirect($response['url']);
        }
    }

    public function stripeCheckoutSuccess(Request $request)
    {
        $now    =   date('Y-m-d H:i:s');
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $response = $stripe->checkout->sessions->retrieve($request->session_id);
        $login_token    =   Session::get('login_token');
        $package_id     =   Session::get('package_id');
        $package_id_exists  =   DB::table('tbl_propose_category')->where('pc_id',$package_id)->get();
        $login_token_exists =   DB::table('tbl_propose_user')->where('p_user_token',$login_token)->get();
        
        $payment_data   =   array(
            'r_payment_id'  =>  $response->id,
            'method'        =>  $response->payment_method_types[0],
            'currency'      =>  $response->currency,
            'user_email'    =>  $response->customer_email,
            'amount'        =>  $package_id_exists[0]->pc_pay_amount,
            'created_at'    =>  $now
        );
        DB::table('tbl_proposal_payments')->insert($payment_data);
        $pay_id =   DB::getPdo()->lastInsertId();
        $data   =   array(
            'pe_user_phone'         =>  $login_token_exists[0]->p_user_phone,
            'pe_amount'             =>  $package_id_exists[0]->pc_pay_amount,
            'created_at'            =>  $now,
            'propose_user_id'       =>  $login_token_exists[0]->p_uid,
            'propose_category_id'   =>  $package_id_exists[0]->pc_id,
            'is_paid'               =>  1,
            'pe_payment_stripe_id'  =>  $pay_id

        );
        
        DB::table('tbl_proposal_events')->insert($data);
        return redirect()->route('eventTab')
                            ->with('success','Payment successful.');
    }
}
