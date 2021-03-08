<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense = Expense::where('user_id',auth()->user()->id)->get();
        return response(ExpenseResource::collection($expense), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expenseCategory()
    {
        $expense = ExpenseCategory::where('user_id',auth()->user()->id)->get();
        return response()->json($expense, 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeExpenseCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'    => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $expenseCategory = new ExpenseCategory();
        $expenseCategory->name = $request->name;
        $expenseCategory->user_id =  auth()->user()->id;
        $expenseCategory->save();

        return response()->json($expenseCategory, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateExpenseCategory(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'    => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }
        $expenseCategory = ExpenseCategory::findOrFail($id);

        $expenseCategory->name = $request->name;

        $expenseCategory->save();

        return response()->json($expenseCategory, 201);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'expense_for'    => 'required',
                'exp_cat_id' => 'required',
                'amount' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $expense = new Expense();
        $expense->user_id =  auth()->user()->id;
        $expense->expense_for = $request->expense_for;
        $expense->is_monthly_expense = $request->monthly_exp?1:0;
        $expense->amount = $request->amount;
        // $expense->ref_no = $request->ref_no;
        $expense->exp_date = $request->exp_date;
        $expense->exp_cat_id = $request->exp_cat_id;
        $expense->note = $request->note;

        $expense->save();

        return response(new ExpenseResource($expense), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        if ($request->has('expense_for')) {
            $expense->expense_for = $request->expense_for;
        }
        if ($request->has('amount')) {
            $expense->amount = $request->amount;
        }
        if ($request->has('ref_no')) {
            $expense->ref_no = $request->ref_no;
        }
        if ($request->has('exp_date')) {
            $expense->exp_date = date("Y-m-d", strtotime($request->exp_date));
        }
        if ($request->has('exp_cat_id') && $request->exp_cat_id !== 'null') {
            $expense->exp_cat_id = $request->exp_cat_id;
        }
        if ($request->has('note')) {
            $expense->note = $request->note;
        }

        $expense->save();

        return response(new ExpenseResource($expense), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function deleteExpenseCategory($id)
    {
        $expensecat = ExpenseCategory::where('id', $id)->first();
        $expensecat->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->first();
        $expense->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }
}
