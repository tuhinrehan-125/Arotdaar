<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitResource;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UnitController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index']]);
    }

    public function index()
    {
        $unit = Unit::where('delete_status', 1)->paginate(10);
        return response(UnitResource::collection($unit), Response::HTTP_OK);
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
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->save();

        return response(new UnitResource($unit), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        if ($request->has('name')) {
            $unit->name = $request->name;
        }
        if ($request->has('description')) {
            $unit->description = $request->description;
        }

        $unit->save();

        return response(new UnitResource($unit), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $unit = Unit::where('id', $id);
        $unit->delete();
        return response()->json(['success'=>true,'message'=>'Deleted successfully'],204);
    }
}
