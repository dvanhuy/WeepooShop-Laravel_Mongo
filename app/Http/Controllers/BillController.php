<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Figure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function index(){
        $bills = Bill::where("id_user", Auth::id())->get();
        return view('Bill.get_form_bill',["bills"=>$bills]);
    }
    public function getdetailform(Bill $billID){
        $details = BillDetail::where("id_bill",$billID->_id)->get();
        $data= [];
        foreach ($details as $key => $detail) {
            $figure = Figure::find($detail->id_figure);
            $detail['billdetail_id'] = $detail["_id"];
            $data[$key] = ($detail->toArray()+$figure->toArray());
        }
        return view('Bill.detail',["details"=>$data]);
    }
}
