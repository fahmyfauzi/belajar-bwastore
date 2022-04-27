<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Transaction;
use App\TransactionDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        //save users data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        //proses checkout
        $code = 'STORE-' . mt_rand(00000, 99999);
        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        //transaction create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'inscurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code,
        ]);

        //save transaction detail
        foreach ($carts as $item) {
            $trx = 'TRX-' . mt_rand(00000, 99999);
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $item->product->id,
                'price' => $item->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx,
            ]);
        }
        //delete cart data
        Cart::where('users_id', Auth::user()->id)->delete();

        //konfigurasi midtrans
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction =
            config('services.midtrans.isProduction');
        // Set sanitization on (default)
        Config::$isSanitized =
            config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds =
            config('services.midtrans.is3ds');

        //array kirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,

            ],
            'enabled_payments' => [
                'permata_va', 'shopeepay', 'gopay', 'bank_transfer'
            ]

        ];
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function callback(Request $request)
    {
    }
}
