<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

class PaymentController extends Controller
{
    private $gateway;

    public function __construct() {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function pay(Request $request, $totalprice)
    {
        try {

            $response = $this->gateway->purchase(array(
                'amount' => $totalprice,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect();
            }
            else{
                return $response->getMessage();
            }

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {

                $arr = $response->getData();

                $payment = new Payment();
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['state'];

                $payment->save();

                $user = Auth::User();
                $userid = $user->id;
                $cart = cart::where('user_id','=',$userid)->get();
                foreach($cart as $cart)
                {
                    $order = new order;
                    $order->name = $cart->name;
                    $order->email = $cart->email;
                    $order->phone = $cart->phone;
                    $order->address = $cart->address;
                    $order->user_id = $cart->user_id;
                    $order->product_title = $cart->product_title;
                    $order->quantity = $cart->quantity;
                    $order->price = $cart->price;
                    $order->image = $cart->image;
                    $order->product_id = $cart->product_id;
                    $order->payment_status = 'paid by paypal';
                    $order->delivery_status = 'processing';
                    $order->save();
                    $cartid = $cart->id;
                    $data = cart::find($cartid);
                    $data->delete();
                }

                return "Payment is Successfull. Your Transaction Id is : " . $arr['id'];

            }
            else{
                return $response->getMessage();
            }
        }
        else{
            return 'Payment declined!!';
        }
    }

    public function error()
    {
        return 'User declined the payment!';   
    }

}