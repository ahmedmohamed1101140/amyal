<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreArea;
use App\Models\Dashboard\Area;
use App\Models\Dashboard\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Session;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data = $request->all();
        if(isset($request->filter) || isset($request->city_id)){
            $areas = $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?filter".$request->filter
                    .'&city_id='.$request->city_id
                );
        }
        else{
            $areas = Area::latest()->paginate(10);
        }
        $cities = City::orderBy('name', 'asc')->select('id','name')->get();
        return view('dashboard.areas.index',compact('areas','cities','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArea $request)
    {
        $area = Area::create($request->validated());
        Session::flash('success', "Area Added Successfully");
        return response()->json($area);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = Area::findOrFail($id);
        return response()->json($area);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArea $request, $id)
    {

        $area = Area::findOrFail($id)->update($request->validated());
        return response()->json($area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
//        Area::findOrFail($id)->delete();
//        return redirect(route('areas.index'));
    }

    public function search(Request $request){
        $areas = Area::query();
        if($request->filter){
            $areas = $areas->where('name','LIKE','%'.$request->filter.'%');
        }
        if($request->city_id){
            $areas = $areas->where('city_id','=',$request->city_id);
        }

        return $areas;

    }
}
