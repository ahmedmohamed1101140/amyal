<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\StoreDepartment;
use App\Models\Dashboard\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Session;

class DepartmentController extends Controller
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
            $departments = $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?filter=".$request->filter
                );
        }
        else{
            $departments = Department::latest()->paginate(10);
        }
        return view('dashboard.departments.index',compact('departments','data'));
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
    public function store(StoreDepartment $request)
    {
        //
        $department = Department::create($request->validated());
        Session::flash('success', "Department Added Successfully");
        return response()->json($department);
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
        $department = Department::findOrFail($id);
        return response()->json($department);
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
    public function update(StoreDepartment $request, $id)
    {
        //
        $department = Department::findOrFail($id)->update($request->validated());
        Session::flash('success',"Department Updated Successfully");
        return response()->json($department);
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
//        Department::findOrFail($id)->delete();
//        Session::flash('success',"Department Deleted Successfully");
//        return redirect(route('departments.index'));
    }

    public function search(Request $request){
        return Department::where('name','LIKE','%'.$request->filter.'%');
    }
}
