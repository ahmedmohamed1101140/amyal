<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreOffice;
use App\Models\Dashboard\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Session;

class OfficeController extends Controller
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
        if($request->filter){
            $offices = $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?filter=".$request->filter
                );;
        }
        else{
            $offices = Office::latest()->paginate(10);
        }
        return view('dashboard.offices.index',compact('offices','data'));
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
    public function store(StoreOffice $request)
    {
        //
        $office = Office::create($request->validated());
        Session::flash('success', "Office Added Successfully");
        return response()->json($office);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $office = Office::findOrFail($id);
        return response()->json($office);
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
    public function update(StoreOffice $request, $id)
    {
        //
        $office = Office::findOrFail($id)->update($request->validated());
        Session::flash('success', "Office Updated Successfully");
        return response()->json($office);
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
//        Office::findOrFail($id)->delete();
//        Session::flash('success',"Office Deleted Successfully");
//        return redirect(route('offices.index'));
    }

    public function search(Request $request){
        return Office::where('name','LIKE','%'.$request->filter.'%');
    }
}
