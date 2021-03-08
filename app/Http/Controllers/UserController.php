<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\Client;
use App\Models\Collection;
use App\Models\Commission;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Products;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create($request->only('name', 'username', 'email')
            + [
                'password' => bcrypt($request->input('password')),
            ]);
        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    public function show(User $user)
    {
        // $user = User::findOrFail($id);
        // dd($user);
        return view('users.show', compact('user'));
    }

    public function dashboardData(Request $request)
    {
        $userid=auth()->user()->id;
        $reportfor = $request->reportfor;
        $cash_payments_data = array();
        $due_payments_data = array();
        $advance_payments_data = array();
        $days_name_array = array();
        $title='';
        $monthlyExp=Expense::where('user_id',$userid)->where('is_monthly_expense',1)->sum('amount');
        $totalMonthlyExp=0;
        $commissions= array();
        if ($reportfor == 'weekly') {
            $title="Weekly Report";
            $totalMonthlyExp=$monthlyExp/7;
            $startDate = Carbon::now()->startOfWeek(Carbon::FRIDAY);
            $endDate =  Carbon::now()->endOfWeek(Carbon::THURSDAY);
            $commissions = $this->getCommissions($userid,$startDate, $endDate);
            $days_array = $this->durations($startDate, $endDate, $reportfor);

            if (!empty($days_array)) {
                foreach ($days_array as $d_no => $d_name) {
                    $cash_payments = $this->cashPayments($userid,$d_no, $reportfor);
                    $due_payments = $this->duePayments($userid,$d_no, $reportfor);
                    $advance_payments = $this->advancePayments($userid,$d_no, $reportfor);
                    array_push($cash_payments_data, $cash_payments);
                    array_push($due_payments_data, $due_payments);
                    array_push($advance_payments_data, $advance_payments);
                    array_push($days_name_array, $d_name);
                }
            }
        } elseif ($reportfor == 'monthly') {
            $title="Monthly Report";
            $totalMonthlyExp=$monthlyExp;
            $startDate = new Carbon('first day of this month');
            $endDate = new Carbon('last day of this month');
            $commissions = $this->getCommissions($userid,$startDate, $endDate);
            $days_array = $this->durations($startDate, $endDate, $reportfor);

            if (!empty($days_array)) {
                foreach ($days_array as $d_no => $d_name) {
                    $cash_payments = $this->cashPayments($userid,$d_no, $reportfor);
                    $due_payments = $this->duePayments($userid,$d_no, $reportfor);
                    $advance_payments = $this->advancePayments($userid,$d_no, $reportfor);
                    array_push($cash_payments_data, $cash_payments);
                    array_push($due_payments_data, $due_payments);
                    array_push($advance_payments_data, $advance_payments);
                    array_push($days_name_array, $d_name);
                }
            }
        } elseif ($reportfor == 'daily') {
            $title="Daily Report";
            $totalMonthlyExp=$monthlyExp/Carbon::now()->daysInMonth;
            $startDate = Carbon::today();
            $endDate = Carbon::tomorrow();
            $commissions = $this->getCommissions($userid,$startDate, $endDate);
            $days_array = $this->durations($startDate, $endDate, $reportfor);
            if (!empty($days_array)) {
                foreach ($days_array as $d_no => $d_name) {
                    $cash_payments = $this->cashPayments($userid,$d_no, $reportfor);
                    $due_payments = $this->duePayments($userid,$d_no, $reportfor);
                    $advance_payments = $this->advancePayments($userid,$d_no, $reportfor);
                    array_push($cash_payments_data, $cash_payments);
                    array_push($due_payments_data, $due_payments);
                    array_push($advance_payments_data, $advance_payments);
                    array_push($days_name_array, $d_name);
                }
            }
        } else {
            $title="Yearly Report";
            $totalMonthlyExp=$monthlyExp*12;
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
            $days_array = $this->durations($startDate, $endDate, $reportfor);
            $commissions = $this->getCommissions($userid,$startDate, $endDate);
            if (!empty($days_array)) {
                foreach ($days_array as $d_no => $d_name) {
                    $cash_payments = $this->cashPayments($userid,$d_no, $reportfor);
                    $due_payments = $this->duePayments($userid,$d_no, $reportfor);
                    $advance_payments = $this->advancePayments($userid,$d_no, $reportfor);
                    array_push($cash_payments_data, $cash_payments);
                    array_push($due_payments_data, $due_payments);
                    array_push($advance_payments_data, $advance_payments);
                    array_push($days_name_array, $d_name);
                }
            }
        }

        $lastestPayment = Payment::where('user_id',$userid)->orderBY('id', 'desc')->take(4)->get();

        $totalCollection = Collection::where('user_id',$userid)->whereBetween('created_at', [$startDate, $endDate])->sum('amount');

        $sumofDateExpense = Expense::where('user_id',$userid)->where('is_monthly_expense',0)->whereBetween('exp_date', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])->sum('amount');
        $countClient = Client::where('user_id',$userid)->get()->count();
        $countCustomer = Customer::where('user_id',$userid)->get()->count();

        $regular_customers =Customer::join('order_products', 'customers.id', '=', 'order_products.customer_id')
            ->selectRaw('customers.*, COALESCE(sum(order_products.quantity),0) total_purchse, sum(order_products.total) as total_amount')
            ->where('customers.delete_status', 1)
            ->where('order_products.user_id', $userid)
            ->where('customers.user_id', $userid)
            ->groupBy('customers.id')
            ->orderBy('total_purchse', 'desc')
            ->take(4)
            ->get();

        $popular_fish =Products::join('order_products', 'products.id', '=', 'order_products.product_id')
            ->selectRaw("products.*, sum(order_products.total) as total_amount")
            ->where('products.delete_status', 1)
            ->where('products.user_id', $userid)
            ->where('order_products.user_id', $userid)
            ->where('products.delete_status', 1)
            ->groupBy('products.id')
            ->orderBy('total_amount', 'desc')
            ->take(4)
            ->get();
        $data = array(
            'title'=>$title,
            'totalcollection' => strval($totalCollection),
            'totalExpense'=>strval(round($totalMonthlyExp+$sumofDateExpense)),
            'totalclient' => strval($countClient),
            'totalcustomer' => strval($countCustomer),
            'regular_customers' => $regular_customers,
            'popular_fish' => $popular_fish,
            'latest_payment' => $lastestPayment,
            'commissions' => $commissions,
            'days' => $days_name_array,
            'cash_payment' => (object) array('data' => $cash_payments_data, 'name' => 'Cash Payment'),
            'due_payment' => (object) array('data' => $due_payments_data, 'name' => 'Due Payment'),
            'advance_payment' => (object) array('data' => $advance_payments_data, 'name' => 'Advance Payment'),
        );

        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function getCommissions($userid,$start, $end)
    {
        $commission= Commission::where('user_id',$userid)->whereBetween('created_at', [$start, $end]);
        $arot_income= $commission->sum('arot_com_income');
        $bazar_income= $commission->sum('bazar_com_income');
        return [
            'arot_commission'=>round($arot_income),
            'bazar_commission'=>round($bazar_income)
        ];
    }

    public function cashPayments($userid,$day, $reportfor)
    {
        Commission::where('user_id',$userid)->selectRaw("sum(arot_com_income) as arot_commission,sum(bazar_com_income) as bazar_commission")->get();
        if ($reportfor == 'weekly' || $reportfor == 'daily' || $reportfor == 'monthly') {
            $cashOnly = OrderProduct::where('user_id',$userid)->where('payment_type', 'Nogod')->whereDate('created_at', $day)->sum('total');
            return $cashOnly;
        } else {
            $cashOnly = OrderProduct::where('user_id',$userid)->where('payment_type', 'Nogod')->whereMonth('created_at', $day)->sum('total');
            return $cashOnly;
        }
    }
    public function duePayments($userid,$day, $reportfor)
    {
        if ($reportfor == 'weekly' || $reportfor == 'daily' || $reportfor == 'monthly') {
            $dueOnly = OrderProduct::where('user_id',$userid)->where('payment_type', 'Bokeya')->whereDate('created_at', $day)->sum('total');
            return $dueOnly;
        } else {
            $dueOnly = OrderProduct::where('user_id',$userid)->where('payment_type', 'Bokeya')->whereMonth('created_at', $day)->sum('total');
            return $dueOnly;
        }
    }

    public function advancePayments($userid,$day, $reportfor)
    {
        if ($reportfor == 'weekly' || $reportfor == 'daily' || $reportfor == 'monthly') {
            $advanceOnly = Advance::where('user_id',$userid)->where('advance_type', 'given')->whereDate('created_at', $day)->sum('amount');
            return $advanceOnly;
        } else {
            $advanceOnly = Advance::where('user_id',$userid)->where('advance_type', 'given')->whereMonth('created_at', $day)->sum('amount');
            return $advanceOnly;
        }
    }

    public function durations($start, $end, $reportfor)
    {
        if ($reportfor == 'weekly' || $reportfor == 'daily' || $reportfor == 'monthly') {
            $result = CarbonPeriod::create($start, '1 day', $end);
            foreach ($result as $dt) {
                $durations_array[$dt->format("Y-m-d")] = $dt->format("d M, Y");
            }
            return $durations_array;
        } else {
            foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
                $date = new \DateTime($month);
                $m_no = $date->format('n');
                $m_name = $date->format('M');
                $durations_array[$m_no] = $m_name;
            }
            return $durations_array;
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('phone_no')) {
            $user->phone_no = $request->phone_no;
        }
        if ($request->has('address')) {
            $user->address = $request->address;
        }
        if ($request->has('email_address')) {
            $user->email_address = $request->email_address;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Updated successfully'], 200);
    }
}
