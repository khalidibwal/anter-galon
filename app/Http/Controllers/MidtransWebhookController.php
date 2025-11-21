<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $req)
    {
        $signature = hash('sha512',
            $req->order_id .
            $req->status_code .
            $req->gross_amount .
            env('MIDTRANS_SERVER_KEY')
        );

        if ($signature !== $req->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $trx = Transaction::where('order_id', $req->order_id)->first();

        if ($trx) {
            $trx->payment_status = $req->transaction_status;
            $trx->save();
        }

        return response()->json(['message' => 'OK']);
    }
}
