<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdvanceResource;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Bank;
use App\Models\Mode;
use App\Models\Advance;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AdvanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index']]);
    }

    public function index()
    {
        $userid=auth()->user()->id;
        $advance = Advance::where('user_id',$userid)->where('delete_status', 1)->latest()->get();
        return response(AdvanceResource::collection($advance), Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        //validation
        $validator = Validator::make(
            $request->all(),
            [
                'client_id'     => 'required',
                'amount'    => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error' => $validator->errors()],422);
        }
        $advance = new Advance();
        $advance->user_id =  auth()->user()->id;
        $advance->client_id = $request->client_id;
        $advance->amount = $request->amount;
        $advance->advance_type = 'given';
        if ($request->payment_method == 'cash') {
            $advance->payment_method = 'Cash';
        } elseif ($request->payment_method == 'Bank') {
            $advance->payment_method = 'Bank';
            $advance->bank_name = $request->bank_name;
            $advance->bank_acc = $request->bank_acc;
        } else {
            $advance->payment_method = $request->payment_method;
            $advance->from_bkash = $request->from_bkash;
            $advance->to_bkash = $request->to_bkash;
        }

        $advance->save();
        return response(new AdvanceResource($advance), Response::HTTP_CREATED);
    }


    public function update(Request $request, $id)
    {

        $advance = Advance::findOrFail($id);
        if ($request->has('clientId')) {
            $advance->client_id = $request->client_id;
        }
        if ($request->has('payment_method')) {
            $advance->payment_method = $request->payment_method;
        }
        if ($request->has('amount')) {
            $advance->amount = $request->amount;
        }
        $advance->save();

        return response(new AdvanceResource($advance), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $advance = Advance::findOrFail($id);
        if ($advance->delete_status == 1) {
            $advance->delete_status = 0;
        } else {
            $advance->delete_status = 1;
        }

        $advance->save();
        return response()->json(['success'=>true,'message'=>'Deleted successfully'],204);
    }
}
