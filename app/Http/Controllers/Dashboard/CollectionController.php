<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\DateReFormat;
use App\FileDownload;
use App\Models\Dashboard\Collection;
use App\Models\Dashboard\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class CollectionController extends Controller
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
        if(isset($request->filter)){
            $collections = $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?date_from".$request->date_from
                    .'&date_to='.$request->date_to
                    .'&status='.$request->status
                    .'&name='.$request->name
                );
        }
        else{
            $collections = Collection::latest()->paginate(10);
        }
        $total_cod = $collections->sum('cod');
        $offices = Office::select('id','name')->latest()->get();
        return view('dashboard.collections.index',compact('collections','total_cod','offices','data'));
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
    public function store(Request $request)
    {
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
        //
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
        $collection = Collection::findOrFail($id);
        if($collection->status == 'Collect'){
            $collection->status = 'Collected';
        }
        $collection->status_agent = auth()->user()->id;
        $collection->save();
        dd('here');
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }

    public function search($request){
        return $this->getSearchResults($request);
    }

    public function export(Request $request){
        $collections = $this->formatCollections(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('collections', $collections, 'xls');
        return redirect()->back();
    }

    public function getSearchResults($request){
        $collections = Collection::query();
        if($request->date_from != null && $request->date_to != null){
            $from = DateReFormat::RefactorDate($request->date_from);
            $to = DateReFormat::RefactorDate($request->date_to);
            $collections->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }

        if($request->office_id != null){
            $collections->where('office_id','=',$request->office_id);
        }

        if($request->status != null){
            $collections->where('status','=',$request->status);
        }

        if($request->name != null){
            $agents = Agent::where('name','LIKE','%'.$request->name.'%')->select('id')->get();
            if(count($agents) > 0){
                $collections->where(function($query) use ($agents){
                    foreach ($agents as $agent){
                        $query->orWhere('agent_id', '=', $agent->id);
                    }
                });
            }
            else{
                $collections->where('agent_id','=','0');
            }
        }

        return $collections;
    }

    public function formatCollections($collections){
        $new_collections = array();
        foreach ($collections as $collection) {
            $data['Tracking Number'] = $collection->order->tracking_number;
            $data['COD'] = $collection->cod;
            $data['Agent Name'] = $collection->agent->name;
            $data['Agent type'] = $collection->agent->type;
            $data['Order Status'] = $collection->order->status;
            $data['Status'] = $collection->status;
            $data['created At'] = $collection->created_at->format('d/m/Y H:i A');
            $data['Agent Change Status'] = $collection->status_agent == null ? '---' : $collection->statusAgent->name;
            $data['Status changed at'] = $collection->updated_at->format('d/m/Y H:i A');
            array_push($new_collections, $data);
        }
        return $new_collections;
    }


}
