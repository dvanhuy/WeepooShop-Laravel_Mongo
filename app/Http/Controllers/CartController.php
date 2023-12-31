<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddCardRequest;
use App\Models\Cart;
use App\Models\Figure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    //
    public function index()
    {
        $carts = Cart::where("id_user", Auth::id())->get();
        $data= [];
        for ($i=0; $i < count($carts); $i++) {
            $figure = Figure::find($carts[$i]->id_figure);
            if($figure){
                $carts[$i]['cart_id'] = $carts[$i]["_id"];
                $data[$i]=($carts[$i]->toArray()+$figure->toArray());
            }
        }
        return view("Cart.get_list_cart", ["carts"=> $data]);
    }
    public function add(AddCardRequest $request){
        // Xử lý dữ liệu
        $existsCart = Cart::where('id_user', $request->id_user)
            ->where('id_figure',  $request->id_figure)
            ->get();
        if($existsCart->count() == 0)
        {
            Cart::create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng'
            ]);
        };
        $soluong = $request->input('so_luong');
        $existsCart[0]->so_luong += (int)$soluong ;
        $existsCart[0]->save();
        // Trả về kết quả
        return response()->json([
            'success' => false,
            'message' => 'Đã thêm '.$soluong.' sản phẩm nữa vào giỏ hàng',
            'data' => $existsCart[0]
        ]);
    }

    public function delete(Cart $cart_id)
    {
        $check = $cart_id->delete();
        if ($check) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa thành công',
            ]);
        }
        // Trả về kết quả
        return response()->json([
            'success' => false,
            'message' => 'Xóa thất bại'
        ]);
    }

    public function update(Request $request){
        $cart = Cart::find($request->input('cartID'));
        $figure = Figure::find($cart->id_figure);
        $update_so_luong = $cart->so_luong + (int)$request->input('updateNumber');
        if ($figure->so_luong_hien_con >= $update_so_luong ){
            $cart->so_luong = $update_so_luong;
            $cart->save();
            return response()->json([
                'success' => true,
                'message' => "cập nhật thành công",
            ]);
        }
        //hết hàng và cập nhật lại thành số hàng còn
        $cart->so_luong = $figure->so_luong_hien_con;
        $cart->save();
        return response()->json([
            'success' => false,
            'message' => "Chỉ còn ".$figure->so_luong_hien_con." mô hình trong kho",
            'so_luong_con' => $figure->so_luong_hien_con,
        ]);
    }

    public function getFormPay(Request $request){
        $cartIDs = explode(',', $request->input('cartIDs'));
        $carts = Cart::whereIn('_id',  $cartIDs)->get();
        $data= [];
        $totalmoney = 0;
        for ($i=0; $i < count($carts); $i++) {
            $figure = Figure::find($carts[$i]->id_figure);
            if($figure){
                $carts[$i]['cart_id'] = $carts[$i]["_id"];
                $data[$i]=($carts[$i]->toArray()+$figure->toArray());
                $data[$i]['tong_tien'] = (int)$data[$i]['gia']*(int)$data[$i]['so_luong'];
                $totalmoney += (int)$data[$i]['tong_tien'];
            }
        }

        return view('Cart.pay',['carts'=>$data,'totalmoney'=>$totalmoney]);
    }

}