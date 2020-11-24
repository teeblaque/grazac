<?php

namespace App\Http\Controllers;

use App\Investor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'amount' => 'required|string',
                'reference' => 'required|string',
            ]);

            $invest = new Investor();
            $invest->name = $request->name;
            $invest->amount = $request->amount;
            $invest->start_date = Carbon::now();
            $invest->end_date = Carbon::now()->addWeekdays(25);
            $invest->reference = $request->reference;

            if ($invest->save()) {
                return response()->json(['status' => true, 'msg' => 'ok', 'data' => $invest], 201);
            }else{
                return response()->json(['status' => true, 'msg' => 'Error saving data'], 500);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

    public function verify($reference = null)
    {
        if ($reference != null) {
            $post_pay = paystack_getcurl("https://api.paystack.co/transaction/verify/" . $reference);
            return response()->json($post_pay);
        } else {
            return response()->json(['status' => false, 'msg' => 'Reference Number cannot be null'], 400);
        }
    }
}
