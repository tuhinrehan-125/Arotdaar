<?php

namespace App\Http\Controllers;

use App\Models\PaymentAccount;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;

class PaymentAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = PaymentAccount::where('user_id',auth()->user()->id)->get();

        return response()->json(['success' => true, 'data' => $accounts], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $account = new PaymentAccount();

        $account->type = $request->type;
        $account->user_id =  auth()->user()->id;
        $account->bank_name = $request->bank_name;
        $account->bank_acc = $request->bank_acc;
        $account->bank_branch = $request->bank_branch;
        $account->bkash_number = $request->bkash_number;
        $account->rocket_number = $request->rocket_number;
        $account->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentAccount  $paymentAccount
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentAccount $paymentAccount)
    {
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentAccount  $paymentAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentAccount $paymentAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentAccount  $paymentAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentAccount $paymentAccount)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentAccount  $paymentAccount
     * @return \Illuminate\Http\Response
     */
    public function accountTypeInfo(Request $request)
    {
        $account_type = $request->type;
        $accounts = PaymentAccount::where('user_id',auth()->user()->id)->where('type', $account_type)->get();
        if (count($accounts) > 0) {
            return response()->json(['success' => true, 'type' => $account_type, 'data' => $accounts], 200);
        } else {
            return response()->json(['success' => false, 'msg' => 'No accounts found for this type of account'], 500);
        }
    }
}
