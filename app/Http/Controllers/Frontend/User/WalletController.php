<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Wallet\TopupRequest;
use App\Domains\Auth\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller{

    public function index(){
        $transactions = WalletTransaction::where('user_id', auth()->user()->id)
            ->orderBy('status', 'DESC')->paginate(20);

        return view('frontend.user.wallet.index', compact('transactions'));
    }

    public function toppup(){

        if(paymentEnabled() == false){
            return redirect()->back()->withErrors('Invalid action.');
        }
        $min = getMinTopUp();

        return view('frontend.user.wallet.toppup', compact('min'));

    }

    public function insert(TopupRequest $request){

        if(paymentEnabled() == false){
            return redirect()->back()->withErrors('Invalid action.');
        }

        $collection_id = getOption('payment_collection_id', '');

        $some_data = array(
            'userSecretKey'=> env('TOYYIB_SECRET_KEY'),
            'categoryCode'=> $collection_id,
            'billName'=> 'Top-up Wallet',
            'billDescription'=> 'Top-up Wallet',
            'billPriceSetting'=>1,
            'billPayorInfo'=>1,
            'billAmount'=> $request->amount*100,
            'billReturnUrl'=> route('frontend.user.wallet.confirm'),
            'billCallbackUrl'=> route('frontend.user.wallet.confirm'),
            'billExternalReferenceNo' => 'AFR341DFI',
            'billTo'=> auth()->user()->name,
            'billEmail'=> auth()->user()->email,
            'billPhone'=> " ",
            'billSplitPayment'=>0,
            'billSplitPaymentArgs'=>'',
            'billPaymentChannel'=>'0',
            'billDisplayMerchant'=>1,
            'billContentEmail'=>'Thank you for purchasing our product!',
            'billChargeToCustomer'=>1
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, getToyyibPayUrl()."/index.php/api/createBill");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);


        #OK
        if($info['http_code'] == 200){

            $obj = json_decode($result);

            $billCOde = $obj[0]->BillCode;

            $redirect = getToyyibPayUrl()."/".$obj[0]->BillCode;

            $transaction = new WalletTransaction();
            $transaction->user_id = auth()->user()->id;
            $transaction->bill_code = $billCOde;
            $transaction->collection_id = $collection_id;
            $transaction->payment_type = 'toyyibPay';
            $transaction->txn_id = '';
            $transaction->receipt = getToyyibPayUrl().'/'.$billCOde;
            $transaction->status = 'unpaid';
            $transaction->amount = $request->amount;
            $transaction->balance = auth()->user()->wallet;

            $transaction->save();

            return redirect($redirect);

        }else{

            return redirect()->back()->with('error', __('Payment return error code! Failed to make payment.'));
        }
    }

    public function confirm(Request $request){

        if(paymentEnabled() == false){
            return redirect()->back()->withErrors('Invalid action.');
        }

        $some_data = array('billCode' => $request->billcode);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, getToyyibPayUrl() . '/index.php/api/getBillTransactions');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

        $result = curl_exec($curl);
        curl_close($curl);

        try {

            $data = json_decode($result)[0];

            if ($data->billpaymentStatus == 1) {

                $transaction = WalletTransaction::where('status', 'unpaid')->where('bill_code', $request->billcode)->firstOrFail();

                $user = User::find($transaction->user_id);
                $user->increment('wallet', $transaction->amount);
                $user->increment('wallet_total', $transaction->amount);

                $transaction->status = 'paid';
                $transaction->txn_id = $data->billpaymentInvoiceNo;
                $transaction->balance = $user->wallet_total;
                $transaction->save();

                return redirect()->route('frontend.user.wallet.index')->withFlashSuccess(__('Payment successfully.'));

            } elseif ($data->billpaymentStatus == 2) {

                return redirect()->route('frontend.user.wallet.index')->withErrors('Payment failed. Status : Pending transaction');
            } elseif ($data->billpaymentStatus == 3) {

                return redirect()->route('frontend.user.wallet.index')->withErrors('Unsuccessful transaction');
            } elseif ($data->billpaymentStatus == 4) {

                return redirect()->route('frontend.user.wallet.index')->withErrors('Payment failed. Status : Pending transaction');
            } else {

                return redirect()->route('frontend.user.wallet.index')->withErrors('Payment failed');
            }

        } catch (\Exception $e) {

            return redirect()->route('frontend.user.wallet.index')->withErrors('Invalid payment.');
        }
    }

}
