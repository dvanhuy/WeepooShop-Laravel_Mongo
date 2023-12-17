<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weepoo Shop</title>
    <link rel="stylesheet" href="{{ asset('css/get_list_figure.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    .top-figure{
        margin-top: 20px;
        position: relative;
    }
    .banner{
        margin-top: 20px;
        width: 100%;
    }
    .banner img{
        width: 100%;
    }
    .show-all{
        text-decoration: none;
        position: absolute;
        right: 50px;
        top: 0;
    }
    .title{
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 20px;
    }
    body{
        margin-bottom: 100px;
    }
</style>
<body>
    @include('header')
    <form action="{{ route('figures.index') }}">
        <div class="search_box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="hidden" name="search-column" value="ten" >
            <input id="inputsearch" name="search-column-value" type="text" placeholder="Tìm kiếm trên Weepoo shop">
            <input type="submit" value="Tìm kiếm" onclick="return redirectToList(event)">
        </div>
    </form>
    <div class="banner">
        <img src="https://file.hstatic.net/1000160337/collection/4_5e0bca7ec7994b62ba3745d62ff271c0.jpg" alt="">
    </div>
    <div class="top-figure">
        <div class="title">
            Mô hình bán chạy nhất
        </div>
        <a class="show-all" href="{{ route('figures.index') }}">
            <div class="">Xem thêm <i class="fa-solid fa-arrow-right"></i></div>
        </a>
        <div class="container_main">
            @for ($i = 0; $i < count($figures); $i++)
            <a class="container_main_item" href="{{ route('figures.showdetail',$figures[$i]['_id']) }}">
                <div class="item_image">
                    @if (str_contains($figures[$i]['hinh_anh'], 'http'))
                        <img src="{{ $figures[$i]['hinh_anh'] }}" >
                    @else
                        <img src="{{ asset($figures[$i]['hinh_anh']) }}" >
                    @endif
                </div>
                <div class="item_name">
                    {{$figures[$i]['ten']}}
                </div>
                <div class="item_price">
                    {{ number_format($figures[$i]['gia'], 0, ',', '.') }} VNĐ
                </div>
                <div class="item_subprice">
                    {{$figures[$i]['updated_at']}}
                </div>
            </a>
            @endfor
        </div>
    </div>
</body>
<script>
    function redirectToList(event){
        const input = document.getElementById('inputsearch')
        if (input.value && input.value != ""){
            return true
        }
        else{
            alert("Chưa nhập giá trị")
            return false
        }
    }
</script>
<style>
    body {
        font-family: 'Nunito', sans-serif;
    }
    .search_box{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50%;
        margin: auto;
        background-color: rgb(244, 244, 244);
        border-radius: 30px;
        padding-left: 20px;
        overflow: hidden;
    }

    .search_box input[type=text]{
        width: 100%;
        height: 35px;
        min-width: 300px;
        outline: none;
        box-sizing: border-box;
        border: none;
        font-size: 20px;
        padding: 10px 20px;
        background-color: transparent;
        font-family: 'Varela Round', sans-serif;
    }
    .search_box input[type=submit]{
        height: 100%;
        width: 100px;
        background-color: transparent;
        border: none;
        padding: 15px 10px;
        font-family: 'Varela Round', sans-serif;
        border-left: 1px solid rgb(168, 168, 168);
        font-size: 15px;
    }

    .search_box input[type=submit]:hover{
        background-color: rgb(86, 179, 229);
        color: white;
    }
</style>
</html>