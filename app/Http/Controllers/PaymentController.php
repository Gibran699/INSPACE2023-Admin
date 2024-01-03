<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xendit\Xendit;
use Carbon\Carbon;
use App\Models\Payment;

class PaymentController extends Controller
{
    private $token = 'xnd_development_kUjlWfEhUcYZ4tjgVIwf9q79O0WEpCcTEoxmqahnMYdgi3SUaR1KCbRJTvxll1';

    public function getListVA(){
        // Testing
        Xendit::setApiKey($this->token);
        $getVABanks = \Xendit\VirtualAccounts::getVABanks();
        
        return response()->json($getVABanks);
    }

    public function createVA(Request $request){
        // Testing
        Xendit::setApiKey($this->token);

        $external_id = 'va-'.time();

        $params = [
            "external_id" => $external_id,
            "bank_code" => "BNI",
            "name" => "Muhammad Priandani Nur Ikhsan",
            "expected_amount" => $request->price,
            "is_closed" => true,
            "expiration_date" => Carbon::now()->addDays(1)->toISOString(),
            "is_single_user" => true
        ];

        $payment = Payment::create([
            'external_id' => $external_id,
            'payment_channel' => 'Virtual Account',
            'email' => $request->email,
            'price' => $request->price
        ]);

        $createVA = \Xendit\VirtualAccounts::create($params);

        return response()->json($createVA);
    }

    public function callbackVA(Request $request){
        $external_id = $request->external_id;
        $status = $request->status;
        $payment = Payment::where('external_id', $external_id)->exists();

        if($payment){
            if($status == 'ACTIVE'){
                $update_status = Payment::where('external_id', $external_id)->update([
                    'status' => 1
                ]);

                if($update_status > 0){
                    return 'ok';
                }else{
                    return 'false';
                }
            }
        }else{
            return response()->json([
                'message' => 'Data not found'
            ]);
        }
    }

    public function getAllInvoice(){
        // Testing
        Xendit::setApiKey($this->token);
        $getAllInvoice = \Xendit\Invoice::retrieveAll();

        return response()->json($getAllInvoice);
    }
}
