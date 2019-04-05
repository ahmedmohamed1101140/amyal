<?php

namespace App\Http\Controllers\Dashboard;

use App\DateReFormat;
use App\FileDownload;
use App\Http\Requests\Dashboard\StoreWallet;
use App\Models\Dashboard\Wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Session;

class WalletController extends Controller
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

            $wallets = $this->search($request)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?filter".$request->filter
                    .'&date='.$request->date
                    .'&account_number='.$request->account_number
                );
            $total =  $this->search($request)->sum('amount');
        }
        else{
            $wallets = Wallet::orderBy('created_at', 'desc')->paginate(10);
            $total = Wallet::all()->sum('amount');
        }
        return view('dashboard.wallet.index',compact('wallets','total','data'));
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
    public function store(StoreWallet $request)
    {
//        dd($request->all());

        $data = $request->validated();
        $data['user_id'] = User::where('account_number' ,'=',$request->account_number)->first()['id'];
        $data['agent_id'] = auth()->user()->id;
        $data['date'] = Carbon::createFromFormat('d/m/Y', $request->date);
        Wallet::create($data);
        Session::flash('success','Wallet Created Successfully');
        return redirect()->back();
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

    public function export(Request $request){
        $wallets = $this->formatWallets(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('wallets',$wallets,'xls');
        return redirect()->back();
    }

    public function search($request){
        return $this->getSearchResults($request);
    }



    public function getSearchResults($request){
        $wallets = Wallet::query();
        if($request->date != null ){
            $to = DateReFormat::RefactorDate($request->date);
            $wallets->whereDate('date','=',$to);
        }

        if($request->account_number){
            $clients = User::where('account_number','=',$request->account_number)->select('id')->get();
            if(count($clients) > 0){
                $wallets->where(function($query) use ($clients){
                    foreach ($clients as $client){
                        $query->orWhere('user_id', '=', $client->id);
                    }
                });
            }
            else{
                $wallets->where('user_id','=','0');
            }

        }
        return $wallets;
    }

    public function formatWallets($wallets){
        $new_wallets = array();
        foreach ($wallets as $wallet){
            $data['Receiver Name'] = $wallet->receiver_name;
            $data['Payment Method'] = $wallet->payment_method;
            $data['Record Number'] = $wallet->record_number;
            $data['Amount'] = $wallet->amount;
            $data['Date'] = $wallet->date;
            $data['Created At'] = $wallet->created_at->format('d/m/Y H:i A');
            array_push($new_wallets,$data);
        }
        return $new_wallets;
    }
}
