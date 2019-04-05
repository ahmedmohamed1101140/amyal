<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreCity;
use App\Models\Dashboard\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Session;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if($request->filter){
            $cities =  $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?filter=".$request->filter
                );
        }
        else{
            $cities = City::latest()->paginate(10);
        }
        return view('dashboard.cities.index',compact('cities','data'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCity $request)
    {
        //
        $city = City::create($request->validated());
        Session::flash('success', "City Added Successfully");
        return response()->json($city);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }


    /**
     * update the status of the city form hide to show
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        $city->status == 'hide' ? $city->status = 'display' : $city->status = 'hide';
        $city->save();
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCity $request, $id)
    {
        $city = City::findOrFail($id)->update($request->validated());
        return response()->json($city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        City::findOrFail($id)->delete();
//        return redirect(route('cities.index'));
    }

    public function search(Request $request){
        return City::where('name','LIKE','%'.$request->filter.'%');
    }
}
