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

            $post_pay = paystack_getcurl("https://api.paystack.co/transaction/verify/" . $request->reference);
            if ($post_pay['status'] == false) {
                return response()->json(['status' => false, 'msg' => 'Reference number is not valid'], 401);
            }else{
                $invest->save();
                return response()->json(['status' => true, 'msg' => 'ok', 'data' => $invest], 201);
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

    public function investment()
    {
        $investment = Investor::all();
        if (count($investment) > 0) {
           return response()->json(['status' => true, 'msg' => 'ok', 'data' => $investment], 200);
        }else{
            return response()->json(['status' => false, 'msg' => 'no investment']);
        }
    }
}
