<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updateSettings(Request $request)
    {
        $setting = Setting::where('user_id',auth()->user()->id)->first();
        if (!$setting) {
            $setting = new Setting();
            $setting->user_id = auth()->user()->id;
            $setting->arot_commission = $request->arot_commission;
            $setting->bazar_commission = $request->bazar_commission;
            $setting->arot_name = $request->arot_name;
            $setting->arot_address = $request->arot_address;
            $setting->arot_phone = $request->arot_phone;
            if ($request->arot_image !== 'null') {
                $image = $request->arot_image;
                $extname = $image->getClientOriginalExtension();
                $img_name = substr(md5(uniqid(rand(1, 6))) . microtime(true), 0, 15) . '.' . $extname;
                $image->move(public_path('images'), $img_name);
                $setting->arot_image = $img_name;
            }
            $setting->save();
        } else {
            if ($request->file('arot_image')) {
                if ($setting->image) {
                    $path = public_path() . "/images/" . basename($setting->image);
                    if ($path) {
                        unlink($path);
                    }
                    $this->storeImg($request->arot_image, $setting);
                } else {
                    $this->storeImg($request->arot_image, $setting);
                }
            }
            $setting->arot_name = $request->arot_name;
            $setting->arot_commission = $request->arot_commission;
            $setting->bazar_commission = $request->bazar_commission;
            $setting->arot_address = $request->arot_address;
            $setting->arot_phone = $request->arot_phone;
            $setting->save();
        }
        return response()->json(['success' => true, 'message' => 'Setting updated successfully']);
    }

    protected function storeImg($image, $setting)
    {
        $extname = $image->getClientOriginalExtension();
        $img_name = substr(md5(uniqid(rand(1, 6))) . microtime(true), 0, 15) . '.' . $extname;
        $image->move(public_path('images'), $img_name);
        $setting->arot_image = $img_name;
    }



    public function index()
    {
        $setting = Setting::where('user_id',auth()->user()->id)->first();
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $invoice_no = 1200;
        if ($lastOrder) {
            $invoice_no = $lastOrder->invoice_no + 1;
        }
        if (!$setting) {
            return response()->json(['success' => true, 'data' => []]);
        } else {
            return response()->json(['success' => true, 'setting' => $setting, 'invoice_no' => $invoice_no]);
        }
    }
}
