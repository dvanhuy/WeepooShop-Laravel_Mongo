<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bill\CheckOutRequest;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Cart;
use App\Models\Figure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VNPAYController extends Controller
{
    public function pay(CheckOutRequest $request)
    {
        $bill = Bill::create([
            'trang_thai' => 'Chờ duyệt',
            'id_user' => Auth::user()['_id'],
            'hinh_anh'=>'images/emptyFigure.webp',
            'so_dien_thoai' => $request['sodienthoai'],
            'dia_chi' => $request['diachi'],
            'tong_tien' => $request['totalmoney'],
            'cardIDs' => $request->input('cartIDs'),
            'phuong_thuc_thanh_toan' => "Tiền mặt khi nhận",
            'da_thanh_toan' =>"Chưa",
        ]);
        if ($request['payments']=='cash'){
            try {
                $bill['phuong_thuc_thanh_toan'] = "Tiền mặt khi nhận";
                $bill['da_thanh_toan'] = "Chưa";
                $bill->save();
                $cartIDs = explode(',', $request->input('cartIDs'));
                $carts = Cart::whereIn('_id',  $cartIDs)->get();
                foreach ($carts as $cart) {
                    // Cập nhật bảng figure
                    $figure = Figure::find($cart->id_figure);
                    $figure->so_luong_hien_con -= $cart->so_luong;
                    $figure->so_luong_da_ban += $cart->so_luong;
                    $figure->save();
                    BillDetail::create([
                        'id_bill' => $bill->id,
                        'id_figure' => $cart->id_figure,
                        'so_luong' => $cart->so_luong,
                    ]);
                    $cart->delete();
                }
    
                return redirect()->route('vnpay.result')->with(["status"=>"Xác nhận thành công"]);
            } catch (\Throwable $th) {
                return redirect()->route('vnpay.result')->with(["status"=>"Xảy ra lỗi"]);
            }
        }
        if ($request['payments']=='vnpay'){
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://localhost:8000/vnpay_php/checkout";
            $vnp_TmnCode = "K5Z8OZ7K"; //Mã website tại VNPAY 
            $vnp_HashSecret = "ZEUURXNVHEXHNTPFIBFIRRZQCTRONHUN"; //Chuỗi bí mật

            $vnp_TxnRef = $bill['_id']; //Mã giao dịch thanh toán tham chiếu của merchant
            $vnp_Amount = (int)($request->totalmoney)*100; // Số tiền thanh toán
            $vnp_Locale = "vn"; //Ngôn ngữ chuyển hướng thanh toán
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                'vnp_IpAddr' =>$_SERVER['REMOTE_ADDR'],
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toan GD: ".$vnp_TxnRef,
                "vnp_OrderType" => "billpayment",
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );
            // $vnp_BankCode = 'NCB'; //Mã phương thức thanh toán

            // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            //     $inputData['vnp_BankCode'] = $vnp_BankCode;
            // }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);
            return redirect()->to($returnData['data']);
        }
        return redirect()->route('vnpay.result')->with(["status"=>"Xảy ra lỗi"]);
    }

    public function checkout(Request $request){
        // 00	Giao dịch thành công
        // 01	Giao dịch chưa hoàn tất
        // 02	Giao dịch bị lỗi
        // 04	Giao dịch đảo (Khách hàng đã bị trừ tiền tại Ngân hàng nhưng GD chưa thành công ở VNPAY)
        // 05	VNPAY đang xử lý giao dịch này (GD hoàn tiền)
        // 06	VNPAY đã gửi yêu cầu hoàn tiền sang Ngân hàng (GD hoàn tiền)
        // 07	Giao dịch bị nghi ngờ gian lận
        // 09	GD Hoàn trả bị từ chối
        if($request->vnp_ResponseCode == "00"){
            try {
                $bill = Bill::find($request->vnp_TxnRef);
                $bill['phuong_thuc_thanh_toan'] = "VNPAY";
                $bill['da_thanh_toan'] = "Rồi";
                $bill->save();
                $cartIDs = explode(',', $bill['cardIDs']);
                $carts = Cart::whereIn('_id',  $cartIDs)->get();
                foreach ($carts as $cart) {
                    // Cập nhật bảng figure
                    $figure = Figure::find($cart->id_figure);
                    $figure->so_luong_hien_con -= $cart->so_luong;
                    $figure->so_luong_da_ban += $cart->so_luong;
                    $figure->save();
                    BillDetail::create([
                        'id_bill' => $bill->id,
                        'id_figure' => $cart->id_figure,
                        'so_luong' => $cart->so_luong,
                    ]);
                    $cart->delete();
                }
                return redirect()->route('vnpay.result')->with(["status"=>"Xác nhận thành công"]);
            } catch (\Throwable $th) {
                return redirect()->route('vnpay.result')->with(["status"=>"Xảy ra lỗi"]);
            }
        }
        else{
            Bill::deleted($request->vnp_TxnRef);
            return redirect()->route('vnpay.result')->with(["status"=>"Xảy ra lỗi"]);
        }
    }

    public function result(){
        return view('Bill.showresult');
    }
}
