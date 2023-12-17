<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/get_form_pay.css')}}">
</head>
<style>
    h3{
        margin: 0;
    }
    .status{
        color: red;
        font-size: 1.05rem;
    }
</style>

<body style="text-align: center;">
    <form action="{{ route('manage.update_bill',$bill['_id']) }}" method="post">
    @csrf
    <div class="content">
        @if(Session::has('status'))
            <div class="status">{{ session('status') }}</div>
        @endif
        <h3>Trạng thái : {{ $bill['trang_thai'] }}</h3>
        <select name="trang_thai" id="trang_thai" style="font-size: 17px; padding: 5px;">
            <option value="Chờ duyệt">Chờ duyệt</option>
            <option value="Đang giao">Đang giao</option>
            <option value="Đã giao">Đã giao</option>
        </select>
        <h3>Đã thanh toán : {{ $bill['da_thanh_toan'] }}</h3>
        <select name="da_thanh_toan" id="da_thanh_toan" style="font-size: 17px; padding: 5px;">
            <option value="Chưa">Chưa</option>
            <option value="Rồi">Rồi</option>
        </select>
        <h3>Phương thức thanh toán : {{ $bill['phuong_thuc_thanh_toan'] }}</h3>
        <select name="phuong_thuc_thanh_toan" id="phuong_thuc_thanh_toan" style="font-size: 17px; padding: 5px;">
            <option value="Tiền mặt khi nhận">Tiền mặt khi nhận</option>
            <option value="VNPAY">VNPAY</option>
        </select>
        <script>
            document.getElementById('trang_thai').value = "{{ $bill['trang_thai'] }}"
            document.getElementById('da_thanh_toan').value = "{{ $bill['da_thanh_toan'] }}"
            document.getElementById('phuong_thuc_thanh_toan').value = "{{ $bill['phuong_thuc_thanh_toan'] }}"
        </script>
        <h3>Id người mua : {{ $bill['id_user'] }}</h3>
        <h2>Thông tin đã chọn</h2>
        <div class="item-title">
            <div>Sản phẩm</div>
            <div>Số lượng</div>
            <div>Tổng</div>
        </div>
        @foreach($details as $detail)
        <div class="item">
            <div class="img">
                @if (str_contains($detail['hinh_anh'], 'http'))
                <img src="{{ $detail['hinh_anh'] }}">
                @else
                <img src="{{ asset($detail['hinh_anh']) }}">
                @endif
            </div>
            <div class="name">
                {{$detail['ten']}}
            </div>
            <div class="dongia">{{number_format($detail['gia'], 0, ',', '.') }} VNĐ</div>
            <div class="soluong">{{$detail['so_luong']}}</div>
            <div class="tongtien">{{number_format($detail['gia']*$detail['so_luong'], 0, ',', '.') }} VNĐ</div>
        </div>
        @endforeach
        <div class="item-footer">
            <div>Tổng tiền</div>
            <div>{{number_format($bill['tong_tien'], 0, ',', '.') }} VNĐ</div>
        </div>
        <h2>Phương thức thanh toán</h1>
        <div class="payments_choose">
            <div>
                <input type="radio" id="cash" disabled name="payments" value="cash" checked>
                <label for="cash">
                    <div>Thanh toán tiền mặt</div>
                </label>
            </div>
            <div>
                <input type="radio" id="vnpay" disabled name="payments" value="vnpay">
                <label for="vnpay">
                    <div>Thanh toán VNPAY</div>
                </label>
            </div>
        </div>
        <script>
            if ("{{ $bill['phuong_thuc_thanh_toan'] }}" == "VNPAY"){
                document.getElementById('vnpay').checked = true
            }
            else{
                document.getElementById('cash').checked = true
            }
        </script>
        <h2>Số điện thoại liên lạc:</h2>
        <input type="text" class="inputtext" name="sodienthoai" disabled  value="{{ $bill['so_dien_thoai'] }}">
        <h2>Địa chỉ giao hàng</h2>
        <input type="text" class="inputtext" name="diachi" disabled value="{{ $bill['dia_chi'] }}">
        <button class="buttonsubmit" style="cursor: pointer;">Cập nhật</button>
        <span>Hoặc <a href="{{ route('manage.get_bill_form') }}">Trờ về</a></span>
    </div>
    </form>
</body>
</html>