<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/get_form_pay.css')}}">
</head>
<body style="text-align: center;">
    <form action="{{route('vnpay.pay')}}" method="get">
    @csrf
        <input type="hidden" name="cartIDs" id="cartIDs">
        <input type="hidden" name="totalmoney" value="{{$totalmoney}}">
        <div class="content">
            <h1>Thông tin đã chọn</h1>
                <div class="item-title">
                    <div>Sản phẩm</div>
                    <div>Số lượng</div>
                    <div>Tổng</div>
                </div>
                @foreach($carts as $cart)
                    <div class="item">
                        <div class="img">
                            @if (str_contains($cart['hinh_anh'], 'http'))
                                <img src="{{ $cart['hinh_anh'] }}" >
                            @else
                                <img src="{{ asset($cart['hinh_anh']) }}" >
                            @endif
                        </div>
                        <div class="name">
                            {{$cart['ten']}}
                        </div>
                        <div class="dongia">{{number_format($cart['gia'], 0, ',', '.') }} VNĐ</div>
                        <div class="soluong">{{$cart['so_luong']}}</div>
                        <div class="tongtien">{{number_format($cart['tong_tien'], 0, ',', '.') }} VNĐ</div>
                    </div>
                @endforeach
                <div class="item-footer">
                    <div>Tổng tiền</div>
                    <div>{{number_format($totalmoney, 0, ',', '.') }} VNĐ</div>
                </div>
            <h1>Phương thức thanh toán</h1>
            <div class="payments_choose">
                <div>
                    <input type="radio" id="cash" name="payments" value="cash" checked>
                    <label for="cash"><div>Thanh toán tiến mặt</div></label>
                </div>
                <div>
                    <input type="radio" id="vnpay" name="payments" value="vnpay">
                    <label for="vnpay"><div>Thanh toán VNPAY</div></label>
                </div>
            </div>
            <button class="buttonsubmit">Xác nhận</button>
            <span class="backbutton">
                Hoặc <a href="{{ route('cart.index') }}">Trở về</a>
            </span>
        </div>
    </form>
</body>
<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const cartIDs = urlParams.get('cartIDs');
    const data = document.getElementById("cartIDs")
    data.value = cartIDs
</script>
</html>