<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Karim007\LaravelBkashTokenize\Facade\BkashPaymentTokenize;
use Karim007\LaravelBkashTokenize\Facade\BkashRefundTokenize;

class BkashTokenizePaymentController extends Controller
{
    public function index()
    {
        return view('bkashT::bkash-payment');
    }
    public function createPayment(Request $request, $price)
    {

        $inv = uniqid();
        $request['intent'] = 'sale';
        $request['mode'] = '0011'; //0011 for checkout
        $request['payerReference'] = $inv;
        $request['currency'] = 'BDT';
        $request['amount'] = $price;
        $request['merchantInvoiceNumber'] = $inv;
        $request['callbackURL'] = config("bkash.callbackURL");;

        $request_data_json = json_encode($request->all());

        $response =  BkashPaymentTokenize::cPayment($request_data_json);
        //$response =  BkashPaymentTokenize::cPayment($request_data_json,1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..

        //store paymentID and your account number for matching in callback request
        // dd($response) //if you are using sandbox and not submit info to bkash use it for 1 response

        if (isset($response['bkashURL'])) return redirect()->away($response['bkashURL']);
        else return redirect()->back()->with('error-alert2', $response['statusMessage']);
    }

    public function callBack(Request $request)
    {
        //callback request params
        // paymentID=your_payment_id&status=success&apiVersion=1.2.0-beta
        //using paymentID find the account number for sending params

        if ($request->status == 'success') {
            $response = BkashPaymentTokenize::executePayment($request->paymentID);
            //$response = BkashPaymentTokenize::executePayment($request->paymentID, 1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
            if (!$response) { //if executePayment payment not found call queryPayment
                $response = BkashPaymentTokenize::queryPayment($request->paymentID);
                //$response = BkashPaymentTokenize::queryPayment($request->paymentID,1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
            }

            if (isset($response['statusCode']) && $response['statusCode'] == "0000" && $response['transactionStatus'] == "Completed") {

                $user = Auth::user();
                $userid = $user->id;
                $datas = Cart::where('user_id', '=', $userid)->get();
                foreach ($datas as $data) {
                    $order = new Order();

                    $order->name = $data->name;
                    $order->email = $data->email;
                    $order->phone = $data->phone;
                    $order->address = $data->address;
                    $order->user_id = $data->user_id;

                    $order->product_title = $data->product_title;
                    $order->quentity = $data->quentity;
                    $order->price = $data->price;
                    $order->image = $data->image;
                    $order->product_id = $data->product_id;
                    $order->payment_status = "Paid";
                    $order->delivery_status = "processing";
                    $order->trxID = $response['trxID'];

                    $order->save();

                    $cart_id = $data->id;
                    $cart = Cart::find($cart_id);
                    $cart->delete();


                    // $userId = Auth::id();
                    // $order = Order::where('user_id', $userId)->first();
                    // $order->trxID = $response['trxID'];
                    // $order->save();
                }
                // Redirect to the order confirmation page
                return redirect()->route('order.show', ['id' => $order->id]);
                return BkashPaymentTokenize::success('Thank you for your payment', $response['trxID']);
            }
            return BkashPaymentTokenize::failure($response['statusMessage']);
        } else if ($request->status == 'cancel') {
            return BkashPaymentTokenize::cancel('Your payment is canceled');
        } else {
            return BkashPaymentTokenize::failure('Your transaction is failed');
        }
    }

    public function searchTnx($trxID)
    {
        //response
        return BkashPaymentTokenize::searchTransaction($trxID);
        //return BkashPaymentTokenize::searchTransaction($trxID,1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
    }

    public function refund(Request $request)
    {
        $paymentID = 'Your payment id';
        $trxID = 'your transaction no';
        $amount = 5;
        $reason = 'this is test reason';
        $sku = 'abc';
        //response
        return BkashRefundTokenize::refund($paymentID, $trxID, $amount, $reason, $sku);
        //return BkashRefundTokenize::refund($paymentID,$trxID,$amount,$reason,$sku, 1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
    }
    public function refundStatus(Request $request)
    {
        $paymentID = 'Your payment id';
        $trxID = 'your transaction no';
        return BkashRefundTokenize::refundStatus($paymentID, $trxID);
        //return BkashRefundTokenize::refundStatus($paymentID,$trxID, 1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
    }

    public function showOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('home.order_show', compact('order'));
    }

    public function downloadPDF($orderId)
    {
        $order = Order::findOrFail($orderId);
        // $isPdf = true;
        $pdf = Pdf::loadView('home.order-confirmation', compact('order',));
        return $pdf->download('order-confirmation.pdf');
    }

    // public function downloadPdf($orderId)
    // {
    //     $order = Order::find($orderId);
    //     $isPdf = true; // Set this flag when generating the PDF
    //     $pdf = PDF::loadView('home.order_confirmation', compact('order', 'isPdf'));
    //     return $pdf->download('order_confirmation.pdf');
    // }
}
