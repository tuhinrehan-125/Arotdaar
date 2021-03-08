<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use App\Models\Client;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    //

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
        $userid= auth()->user()->id;
        $client = Client::where('user_id',$userid)->where('delete_status', 1)->paginate(10);
        return response(ClientResource::collection($client), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        //validation
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
                'mobile_no'    => 'required',
                'nid_no'    => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error' => $validator->errors()],422);
        }

        $client = new Client();
        $client->name = $request->name;
        $client->user_id = auth()->user()->id;
        $client->address = $request->address;
        $client->mobile_no = $request->mobile_no;
        $client->company_name = $request->company_name;
        $client->nid_no = $request->nid_no;
        $client->commission_rate = $request->commission_rate;

        $client->save();

        return response(new ClientResource($client), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {

        $client = Client::findOrFail($id);

        if ($request->has('name')) {
            $client->name = $request->name;
        }
        if ($request->has('address')) {
            $client->address = $request->address;
        }
        if ($request->has('mobile_no')) {
            $client->mobile_no = $request->mobile_no;
        }
        if ($request->has('company_name')) {
            $client->company_name = $request->company_name;
        }
        if ($request->has('nid_no')) {
            $client->nid_no = $request->nid_no;
        }
        if ($request->has('commission_rate')) {
            $client->commission_rate = $request->commission_rate;
        }

        $client->save();

        return response(new ClientResource($client), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        if ($client->delete_status == 1) {
            $client->delete_status = 0;
        } else {
            $client->delete_status = 1;
        }

        $client->save();
        return response()->json(['success'=>true,'message'=>'Deleted successfully'],204);
    }

    public function clientSearch(Request $request)
    {
        $name=$request->name;
        if($name){
        $client = Client::where('name', 'LIKE', "%$name%")->get();
        return response(ClientResource::collection($client), Response::HTTP_OK);
        }

    }
}
