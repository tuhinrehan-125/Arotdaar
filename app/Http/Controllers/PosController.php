<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $lastOrder= Order::latest()->first();
        return response()->json(['success' => true, 'pos' => $lastOrder->invoice_no], 200);
    }
}
