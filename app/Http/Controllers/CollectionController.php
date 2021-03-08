<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\CustomerCollectionResource;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\Mode;
use App\Models\Collection;
use App\Models\OrderProduct;
use Collator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CollectionController extends Controller
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
        $userid=auth()->user()->id;
        $customer = Customer::where('user_id',$userid)->get();
        return response(CustomerCollectionResource::collection($customer), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'customer_id'     => 'required',
                'payment_method'     => 'required',
                'amount'    => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $collection = new Collection();
        $collection->user_id =  auth()->user()->id;
        $collection->customer_id = $request->customer_id;
        $collection->payment_method = $request->payment_method;
        $collection->order_product_id = $request->order_product_id;
        $collection->amount = $request->amount;

        $collection->save();
        $orderProducts = OrderProduct::orderBy('id', 'desc')->get();
        return response(CollectionResource::collection($orderProducts), Response::HTTP_OK);
    }


    public function update(Request $request, $id)
    {

        $collection = Collection::findOrFail($id);

        if ($request->has('customer_id')) {
            $collection->customer_id = $request->customer_id;
        }
        if ($request->has('payment_method')) {
            $collection->payment_method = $request->payment_method;
        }
        if ($request->has('amount')) {
            $collection->amount = $request->amount;
        }
        $collection->save();

        return response(new CollectionResource($collection), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);
        if ($collection->delete_status == 1) {
            $collection->delete_status = 0;
        } else {
            $collection->delete_status = 1;
        }

        $collection->save();
        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }


    public function customerDueMoney(Request $request)
    {
        $customer_id = $request->customer;
        $customer = Customer::find($customer_id);
        $dueamount = $customer->OrderProduct()->where('payment_type', 'Bokeya')->sum('total');
        return response()->json(['success' => true, 'dueamount' => round($dueamount)], 200);
    }

    public function customerCollectionHistory(Request $request)
    {

        $customer_id = $request->customer_id;

        $customer = Customer::find($customer_id)->only('id','name');
        $orderProducts = OrderProduct::where('user_id',auth()->user()->id)->where('customer_id', $customer_id)->orderBy('id', 'desc')->get();

        return response()->json(['record' =>CollectionResource::collection($orderProducts),'customer'=>$customer]);
    }
    public function bulkCollection(Request $request)
    {
        $order_pro_ids = $request->id; //array of ids
        $payment_method = $request->payment_method;
        $customer_id = $request->customer_id;
        $amount = $request->amount; //200
        $bank_id = $request->bank_id;
        $from_bKash = $request->from_bKash;
        $to_bKash = $request->to_bKash;
        DB::beginTransaction();
        try {
            foreach ($order_pro_ids as $order_pro_id) {
                $orderPorduct = OrderProduct::find($order_pro_id);
                $totalprice = $orderPorduct->total; //600
                $totalpaid = $orderPorduct->Collection ? $orderPorduct->Collection->sum('amount') : 0; //300
                $dueamount = $totalprice - $totalpaid; //300
                $restamount=$amount >= $dueamount?$dueamount:$amount;
                if ($restamount) {
                    $collection = new Collection();
                    $collection->user_id =auth()->user()->id;
                    $collection->customer_id = $customer_id;
                    $collection->payment_method = $payment_method;
                    $collection->bank_id = $bank_id;
                    $collection->from_bKash = $from_bKash;
                    $collection->to_bKash = $to_bKash;
                    $collection->order_product_id = $order_pro_id;
                    $collection->amount = $restamount;
                    $collection->save();
                }
                $amount -= $dueamount;
                if ($amount <= 0) {
                    break;
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'errmsg' => $e->getMessage()], 500);
        }
        DB::commit();
    }
}
