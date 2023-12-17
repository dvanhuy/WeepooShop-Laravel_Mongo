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
                        Quản lý người dùng
                    </div>
                    @if(Session::has('status'))
                        <div class="status">{{ session('status') }}</div>
                    @endif
                    <div class="searchbox">
                        <form action=" {{ route('manage.get_users_form') }} " method="get">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" id="" placeholder="Tìm kiếm email ...">
                        </form>
                    </div>
                    <!-- <a href="{{ route('figures.get_form_add') }}" class="button-add">
                        <i class="fa-solid fa-plus"></i>
                        Thêm mới
                    </a> -->
                </div>
                <div class="table-data">
                    <div class="title-table">
                        <div>Email</div>
                        <div>Tên người dùng</div>
                        <div>Avatar</div>
                        <div>Vai trò</div>
                        <div>Thao tác</div>
                    </div>
                    @foreach($users as $user)
                    <div class="item-table">
                        <div>{{ $user['email'] }}</div>
                        <div>{{ $user['name'] }}</div>
                        <div class="img_box_item">
                            @if (str_contains($user['avatar'], 'http'))
                                <img src="{{ $user['avatar'] }}" >
                            @else
                                <img src="{{ asset($user['avatar']) }}" >
                            @endif
                        </div>
                        @if (array_key_exists('role', $user))
                            <div>{{$user['role'] ? $user['role'] : 'Không'}}</div>
                        @else
                            <div>Không</div>
                        @endif
                        <div class="thaotac">
                            <!-- <a ><i class="fa-solid fa-eye"></i></a> -->
                            <a href="{{ route('manage.get_form_update_user',$user['_id']) }}"><i class="fa-solid fa-pen"></i></a>
                            <a href="{{ route('manage.delete_user',$user['_id']) }}" onclick="return confirm('Bạn có chắn muốn xóa không?');"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{ $users->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.custom_pagination') }}
            </div>
        </div>
    </main>
</body>

</html>