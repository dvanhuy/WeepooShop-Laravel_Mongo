<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý</title>
    <link rel="stylesheet" href="{{ asset('css/manage_page.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    .title-table,.item-table{
    grid-template-columns: 1.5fr 1fr 1.5fr 1fr 1.5fr;
}
</style>
<body>
    <main class="main-container">
        @include('Admin/headerAdmin')
        <div class="second-container">
            <div class="content">
                <div class="header-content">
                    <div class="title">
                        Quản lý hóa đơn
                    </div>
                    @if(Session::has('status'))
                        <div class="status">{{ session('status') }}</div>
                    @endif
                    <!-- <div class="searchbox">
                        <form action=" {{ route('manage.get_users_form') }} " method="get">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" id="" placeholder="Tìm kiếm email ...">
                        </form>
                    </div> -->
                    <!-- <a href="{{ route('figures.get_form_add') }}" class="button-add">
                        <i class="fa-solid fa-plus"></i>
                        Thêm mới
                    </a> -->
                </div>
                <div class="table-data">
                    <div class="title-table">
                        <div>Mã hóa đơn</div>
                        <div>Tổng tiền</div>
                        <div>Mã người mua</div>
                        <div>Trạng thái</div>
                        <div>Thao tác</div>
                    </div>
                    @foreach($bills as $bill)
                    <div class="item-table">
                        <div>{{ $bill['_id'] }}</div>
                        <div>{{ number_format($bill['tong_tien'], 0, ',', '.')}}</div>
                        <div>{{ $bill['id_user'] }}</div>
                        <div>{{ $bill['trang_thai'] }}</div>
                        <div class="thaotac">
                            <a href="{{ route('bill.detail',$bill['_id']) }}"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('manage.get_form_update_user',$bill['_id']) }}"><i class="fa-solid fa-pen"></i></a>
                            <a href="{{ route('manage.delete_user',$bill['_id']) }}" onclick="return confirm('Bạn có chắn muốn xóa không?');"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $bills->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.custom_pagination') }}
            </div>
        </div>
    </main>
</body>

</html>