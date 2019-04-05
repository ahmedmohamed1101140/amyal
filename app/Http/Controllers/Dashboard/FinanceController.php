<?php

namespace App\Http\Controllers\Dashboard;

use App\DateReFormat;
use App\FileDownload;
use App\Models\Dashboard\Finance;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class FinanceController extends Controller
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
            $finances = $this->search($request)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?filter".$request->filter
                    ."&date_from".$request->date_from
                    .'&date_to='.$request->date_to
                    .'&status='.$request->status
                    .'&order_status='.$request->order_status
                    .'&account_number='.$request->account_number
                );
        }
        else{
            $finances = Finance::latest()->paginate(10);
        }
        $total_cod = $finances->sum('cod');
        $total_shipping_fees = $finances->sum('shipping_fees');
        $total_remains = $finances->sum('remains');


        return view('dashboard.finance.index',compact('finances',
            'total_cod',
            'total_remains',
            'total_shipping_fees',
            'data'
        ));
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
        $finance = Finance::findOrFail($id);
        if($finance->status != 'Paid'){
            $finance->status = 'Paid';
        }
        $finance->agent_id = auth()->user()->id;
        $finance->save();
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


    public function exportExcel(Request $request){
        $finances = $this->formatFinances(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('finances',$finances,'xls');
        return redirect()->back();
    }

    public function getSearchResults($request){
        $finances = Finance::query();
        if($request->date_from != null && $request->date_to != null){
            $from = DateReFormat::RefactorDate($request->date_from);
            $to = DateReFormat::RefactorDate($request->date_to);

            $finances->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }

        if($request->order_status){
            $finances->where('order_status','=',$request->order_status);
        }

        if($request->status){
            $finances->where('status','=',$request->status);
        }

        if($request->account_number){
            $clients = User::where('account_number','=',$request->account_number)->select('id')->get();
            if(count($clients) > 0){
                $finances->where(function($query) use ($clients){
                    foreach ($clients as $client){
                        $query->orWhere('user_id', '=', $client->id);
                    }
                });
            }
            else{
                $finances->where('user_id','=','0');
            }

        }
        return $finances;
    }

    /**
     * @param $orders
     * @return array
     * change the orders format to new custom format
     * to export these data into excel file
     */
    public function formatFinances($finances){
        $new_finances = array();
        foreach ($finances as $finance){
            $data['Account Number'] = $finance->user->account_number;
            $data['Agent Name'] = $finance->agent == null ? '---' : $finance->agent->name;
            $data['Tracking Number'] = $finance->order->tracking_number;
            $data['cod'] = (string)$finance->cod;
            $data['Shipping Fees'] = $finance->shipping_fees;
            $data['Remain'] = $finance->cod - $finance->shipping_fees;
            $data['Status'] = $finance->status;
            $data['Order Status'] = $finance->order_status;
            $data['Created At'] = $finance->created_at->format('d/m/Y H:i A');
            $data['Updated At'] = $finance->updated_at->format('d/m/Y H:i A');
            array_push($new_finances,$data);
        }
        return $new_finances;
    }

}
