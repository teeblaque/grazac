<?php

namespace App\Http\Controllers;

use App\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::all();
        if (count($loans) > 0) {
            return response()->json(['status' => true, 'msg' => 'ok', 'data' => $loans], 200);
        }else{
            return response()->json(['status' => false, 'msg' => 'no data']);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'interest_rate' => 'required|string',
                'amount' => 'required|string',
                'tenure' => 'required|string',
            ]);

            $loan = new Loan();
            $loan->user_id = Auth::id();
            $loan->name = $request->name;
            $loan->description = $request->description;
            $loan->interest_rate = $request->interest_rate;
            $loan->amount = $request->amount;
            $loan->tenure = $request->tenure;

            if ($loan->save()) {
                return response()->json(['status' => true, 'msg' => 'Loan created succesfully'], 201);
            }else{
                return response()->json(['status' => false, 'msg' => 'Kindly try again'], 500);
            }

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }
}
