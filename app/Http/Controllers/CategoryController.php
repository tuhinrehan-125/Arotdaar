<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubCategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
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

        $category = Category::where('user_id',$userid)->where('delete_status', 1)->paginate(10);

        return response(CategoryResource::collection($category), Response::HTTP_OK);
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error' => $validator->errors()],422);
        }

        $category = new Category();
        $category->user_id = auth()->user()->id;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response(new CategoryResource($category), Response::HTTP_CREATED);
    }

    public function getSubcategories(Category $category)
    {
        return response(SubCategoryResource::collection($category->SubCategories), Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);

        if ($request->has('name')) {
            $category->name = $request->name;
        }
        if ($request->has('description')) {
            $category->description = $request->description;
        }

        $category->save();

        return response(new CategoryResource($category), Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->first();
        $category->delete_status = 0;
        $category->save();

        return response()->json(['success'=>true,'message'=>'Deleted successfully'],204);
    }
}
