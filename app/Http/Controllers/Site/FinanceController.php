<?php

namespace App\Http\Controllers\Site;

use App\DateReFormat;
use App\FileDownload;
use App\Models\Dashboard\Finance;
use App\Models\Dashboard\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class FinanceController extends Controller
{
    //
    public function index(Request $request){
        if($request->filter)
            return $this->search($request);

        $finances = Finance::where('user_id',auth()->user()->id)->latest()->paginate(10);
        $total_cod = $finances->sum('cod');
        $total_shipping_fees = $finances->sum('shipping_fees');
        $total_remains = $finances->sum('remains');


        $wallets = Wallet::where('user_id',auth()->user()->id)->latest()->get();
        return view('site.finance.index',compact(
            'wallets',
            'finances',
            'total_cod',
            'total_remains',
            'total_shipping_fees'
        ));
    }

    public function export(Request $request){
        $finances = $this->format_finances(
            $this->getSearchResults($request)
            ->latest()
            ->get()
        );
        FileDownload::downloadCSV('finances', $finances, 'xls');
        return redirect()->back();

    }

    public function search($request){
        $finances = $this->getSearchResults($request)
            ->latest()
            ->paginate(10)
            ->setPath(
                URL::current()
                ."?date_from".$request->date_from
                .'&date_to='.$request->date_to
                .'&status='.$request->status
                .'&order_status='.$request->order_status
            );
        $data = $request->all();
        $total_cod = $finances->sum('cod');
        $total_shipping_fees = $finances->sum('shipping_fees');
        $total_remains = $finances->sum('remains');

        $wallets = Wallet::where('user_id',auth()->user()->id)->latest()->get();
        return view('site.finance.index',compact('wallets','finances','data','total_shipping_fees','total_cod','total_remains'));

    }


    public function exportWallet(){
        $wallets = $this->format_wallet(Wallet::where('user_id',auth()->user()->id)->latest()->get());
        FileDownload::downloadCSV('wallet', $wallets, 'xls');
        return redirect()->back();
    }



    public function getSearchResults($request){
        $finances = Finance::where('user_id',auth()->user()->id);
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

        return $finances;
    }

    public function format_finances($finances){
        $new_finances = array();
        foreach ($finances as $finance) {
            $data['Tracking Number'] = $finance->order->tracking_number;
            $data['cod'] = (string)$finance->cod;
            $data['Shipping Fees'] = $finance->shipping_fees;
            $data['Remain'] = $finance->cod - $finance->shipping_fees;
            $data['Order Status'] = $finance->order->status;
            $data['Finance Status'] = $finance->status;
            $data['created At'] = $finance->created_at->format('d/m/Y H:i A');
            array_push($new_finances, $data);
        }
        return $new_finances;
    }

    public function format_wallet($wallets){
        $new_wallets = array();
        foreach ($wallets  as $wallet) {
            $data['Date'] = $wallet->created_at->format('d/m/Y H:i A');
            $data['Receiver Name'] = $wallet->receiver_name;
            $data['Payment Method'] = $wallet->payment_method;
            $data['Amount'] = $wallet->amount;
            $data['Record number'] = $wallet->record_number;
            array_push($new_wallets, $data);
        }
        return $new_wallets;
    }

}
