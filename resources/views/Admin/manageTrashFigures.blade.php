<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý</title>
    <link rel="stylesheet" href="{{ asset('css/manage_page.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <main class="main-container">
        @include('Admin/headerAdmin')
        <div class="second-container">
            <div class="content">
                <div class="header-content">
                    <div class="title">
                        Quản lý sản phẩm (trash)
                    </div>
                    @if(Session::has('status'))
                        <div class="status">{{ session('status') }}</div>
                    @endif
                    <div class="searchbox">
                        <form action=" {{ route('manage.get_figures_form') }} " method="get">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" id="" placeholder="Tìm kiếm sản phẩm ...">
                        </form>
                    </div>
                    <a href="" class="button-add">
                        <i class="fa-solid fa-plus"></i>
                        Thêm mới
                    </a>
                </div>
                <div class="table-data">
                    <div class="title-table">
                        <div>Tên mô hình</div>
                        <div>Giá tiền</div>
                        <div>Hình ảnh</div>
                        <div>Chất liệu</div>
                        <div>Thao tác</div>
                    </div>
                    @foreach($figures as $figure)
                    <div class="item-table">
                        <div>{{ $figure['ten'] }}</div>
                        <div>{{ number_format($figure['gia'], 0, ',', '.') }} đ</div>
                        <div class="img_box_item">
                            @if (str_contains($figure['hinh_anh'], 'http'))
                                <img src="{{ $figure['hinh_anh'] }}" >
                            @else
                                <img src="{{ asset($figure['hinh_anh']) }}" >
                            @endif
                        </div>
                        <div>{{ $figure['chat_lieu'] }}</div>
                        <div class="thaotac">
                            <a href="{{ route('figures.showdetail',$figure['_id']) }}"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('figures.restore',$figure['_id']) }}"><i class="fa-solid fa-trash-can-arrow-up"></i></a>
                            <a href="{{ route('figures.deletperma',$figure['_id']) }}" onclick="return confirm('Bạn có chắn muốn xóa vĩnh viễn không?');"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $figures->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.custom_pagination') }}
            </div>
        </div>
    </main>
</body>

</html>