<div class="first-container">
    <a href="{{ route('get_home_page') }}">
        <div class="logo">Weepoo</div>
    </a>
    <nav>
        <ul>
            <a href="{{ route('manage.get_figures_form') }}">
                <li class="{{ Route::currentRouteName() == 'manage.get_figures_form' ? 'active' : ''  }}">
                    <div class="icon">
                        <i class="fa-solid fa-person-skating"></i>
                    </div>
                    <div class="text-menu">Quản lý mô hình</div>
                </li>
            </a>
            <a href="{{ route('manage.get_users_form') }}" >
                <li class="{{ Route::currentRouteName() == 'manage.get_users_form' ? 'active' : ''  }}">
                    <div class="icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="text-menu">Quản lý người dùng</div>
                </li>
            </a>
            <a >
                <li>
                    <div class="icon">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div class="text-menu">Quản lý hóa đơn</div>
                </li>
            </a>
        </ul>
    </nav>
    <!-- <div class="backbutton">
                <i class="fa-solid fa-right-from-bracket" style="transform: rotate(180deg);"></i>
                Trở về
            </div> -->
</div>