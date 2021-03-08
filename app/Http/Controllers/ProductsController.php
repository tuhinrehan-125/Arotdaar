<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'productSearch']]);
    }

    public function index()
    {
        $product = Products::where('user_id',auth()->user()->id)->where('delete_status', 1)->get();
        return response(ProductResource::collection($product), Response::HTTP_OK);
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name'    => 'required',
                'category_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $product = new Products();
        $product->user_id = auth()->user()->id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->name = $request->name;
        $product->details = $request->details;
        if ($request->image !== 'null') {
            $image = $request->image;
            $extname = $image->getClientOriginalExtension();
            $img_name = substr(md5(uniqid(rand(1, 6))) . microtime(true), 0, 15) . '.' . $extname;
            $image->move(public_path('images'), $img_name);
            $product->image = $img_name;
        }
        $product->save();

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    public function show(Products $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        if ($request->has('name')) {
            $product->name = $request->name;
        }
        if ($request->has('category_id')) {
            $product->category_id = $request->category_id;
        }
        if ($request->has('subcategory_id') && $request->subcategory_id !== 'null') {
            $product->subcategory_id = $request->subcategory_id;
        }
        if ($request->has('details')) {
            $product->details = $request->details;
        }
        if ($request->file('image')) {
            if ($product->image) {
                $path = public_path() . "/images/" . basename($product->image);
                unlink($path);
                $this->storeImg($request->image, $product);
            } else {
                $this->storeImg($request->image, $product);
            }
        }
        $product->save();

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }

    protected function storeImg($image, $product)
    {
        $extname = $image->getClientOriginalExtension();
        $img_name = substr(md5(uniqid(rand(1, 6))) . microtime(true), 0, 15) . '.' . $extname;
        $image->move(public_path('images'), $img_name);
        $product->image = $img_name;
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        if ($product->delete_status == 1) {
            $product->delete_status = 0;
        } else {
            $product->delete_status = 1;
        }
        $product->save();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }

    public function productSearch(Request $request)
    {
        $name=$request->name;
        if($name){
        $product = Products::where('user_id', auth()->user()->id)->where('name', 'LIKE', "%$name%")->get();
        return response(ProductResource::collection($product), Response::HTTP_OK);
        }

    }
}
