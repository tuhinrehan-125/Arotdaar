<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientPaymentResource;
use App\Http\Resources\PaymentResource;
use App\Models\Advance;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Mode;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //$this->middleware('auth:sanctum', ['except' => ['index']]);
    }

    public function index()
    {
        $clients = Client::where('user_id',auth()->user()->id)->get();
        return response(ClientPaymentResource::collection($clients), Response::HTTP_OK);
        // $orders = Order::orderBy('id','desc')->get();
        // return response(PaymentResource::collection($orders), Response::HTTP_OK);
    }


    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'client_id'     => 'required',
                'select_mode'     => 'required',
                'amount'    => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $payment = new Payment();

        $payment->user_id = auth()->user()->id;
        $payment->client_id = $request->client_id;
        $payment->order_id = $request->order_id;

        $payment->payment_amount = $request->amount;

        if ($request->select_mode == 'bKash') {
            $payment->select_mode = 'bKash';
            $payment->from_bKash = $request->from_bKash;
            $payment->to_bKash = $request->to_bKash;
        } elseif ($request->select_mode == 'Bank') {
            $payment->select_mode = 'Bank';
            $payment->bank_id = $request->bank_id;
            $payment->bank_code_id = $request->bank_code_id;
        } else {
            $payment->select_mode = 'Cash';
        }
        if ($request->adjust_advance > 0) {
            $advance = new Advance();
            $data = array(
                'user_id' => auth()->user()->id,
                'advance_type' => 'taken',
                'client_id' => $request->client_id,
                'amount' => $request->adjust_advance,
                'payment_method' => $request->select_mode,
            );
            $advance->create($data);
        }
        $payment->adjust_advance = $request->adjust_advance;

        $payment->save();

        return response()->json(['success' => true, 'data' => $payment], 200);

        // /return response(new PaymentResource($payment), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {

        $payment = Payment::findOrFail($id);

        if ($request->has('client_id')) {
            $payment->client_id = $request->client_id;
        }
        if ($request->has('select_mode')) {
            $payment->select_mode = $request->select_mode;
        }
        if ($request->has('payment_amount')) {
            $payment->payment_amount = $request->payment_amount;
        }
        if ($request->has('adjust_advance')) {
            $payment->adjust_advance = $request->adjust_advance;
        }


        $payment->save();
        return response(new PaymentResource($payment), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $client = Payment::findOrFail($id);
        if ($client->delete_status == 1) {
            $client->delete_status = 0;
        } else {
            $client->delete_status = 1;
        }

        $client->save();
        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }


    public function clientPaymentHistory(Request $request)
    {
        $client_id = $request->client_id;
        $client = Client::find($client_id);
        $clientInfo = $client->only('id', 'name', 'mobile_no');
        $givenadvance = $client->Advance()->where('advance_type', 'given')->sum('amount');
        $takenadvance = $client->Advance()->where('advance_type', 'taken')->sum('amount');
        $due = $givenadvance - $takenadvance;
        $clientInfo['advance_ude'] = $due;
        $orders = Order::where('client_id', $client_id)->orderBy('id', 'desc')->get();
        return response()->json(['record' => PaymentResource::collection($orders), 'client' => $clientInfo]);
    }

    public function bulkPayment(Request $request)
    {
        // /return $request->all();
        $order_ids = $request->id; //array of ids
        $payment_method = $request->payment_method;
        $client_id = $request->client_id;
        $amount = $request->amount; //200
        $bank_id = $request->bank_id; //200
        $from_bKash = $request->from_bKash; //200
        $to_bKash = $request->to_bKash; //200.
        $adjust_advance = $request->adjust_advance;
        DB::beginTransaction();
        try {
            if ($amount > 0) {
                foreach ($order_ids as $order_id) {
                    $order = Order::find($order_id);
                    $totalprice = $order->grand_total; //600
                    $totalpaid = $order->Payment ? $order->Payment->sum('payment_amount') : 0; //300
                    $dueamount = $totalprice - $totalpaid; //300
                    $restamount = $amount >= $dueamount ? $dueamount : $amount;
                    if ($restamount) {
                        $payment = new Payment();
                        $payment->user_id = auth()->user()->id;
                        $payment->client_id = $client_id;
                        $payment->select_mode = $payment_method;
                        $payment->order_id = $order_id;
                        $payment->bank_id = $bank_id;
                        $payment->from_bKash = $from_bKash;
                        $payment->to_bKash = $to_bKash;
                        $payment->adjust_advance = $adjust_advance;
                        $payment->payment_amount = $restamount;
                        $payment->save();
                    }
                    $amount -= $dueamount;
                    if ($amount <= 0) {
                        break;
                    }
                }
            }
            if ($adjust_advance > 0) {
                $advance = new Advance();
                $data = array(
                    'advance_type' => 'taken',
                    'user_id' => auth()->user()->id,
                    'client_id' => $client_id,
                    'amount' => $adjust_advance,
                    'payment_method' => $payment_method,
                );
                $advance->create($data);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }
        DB::commit();
    }
    // public function getAdvanceDue($id)
    // {

    //     $givenadvance = $this->Client->Advance()->where('advance_type', 'given')->sum('amount');
    //     $takenadvance = $this->Client->Advance()->where('advance_type', 'taken')->sum('amount');
    //     $due = $givenadvance - $takenadvance;
    // }
}
