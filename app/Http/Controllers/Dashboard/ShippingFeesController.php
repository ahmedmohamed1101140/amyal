<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Dashboard\City;
use App\Models\Dashboard\ShippingFees;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;

class ShippingFeesController extends Controller
{
    //
    public function update_shipping_fees(Request $request, $client_id)
    {
        $client = User::FindOrFail($client_id);
        try {
            $data = array_filter($request->except('_token'), function ($key) {
                return $key;
            }, ARRAY_FILTER_USE_BOTH);
            DB::beginTransaction();
            ShippingFees::where('user_id', '=', $client->id)->delete();
            foreach ($data as $key => $value) {
                if($value >= 100000 || $value < 0){
                    throw new \Exception('City price over limit!!');
                }
                if (!City::find($key))
                    throw new \Exception('invalid selected city value !!');
                if ($this->add_shipping_fee($key, $client->id, $value))
                    throw new \Exception('operation failed  !!');
            }
            DB::commit();
            Session::flash('success', 'Fees Added Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function add_shipping_fee($city_id, $user_id, $fee)
    {
        $data['city_id'] = $city_id;
        $data['user_id'] = $user_id;
        $data['fees'] = $fee;
        ShippingFees::create($data);
    }
}
