các lệnh cần chạy

//////////////////////////////////////////////////////////////////////////
sau khi clone 

1   -> composer install --ignore-platform-reqs

2   -> npm install (có thể ko chạy)

3   -> cp .env.example .env

    -> copy file env trên weepoo
    -> https://bom.so/envweepoo

4   -> php artisan key:generate
    -> sinh APP_KEY trong .env

<!-- 5   -> php artisan storage:link

6   -> chỉnh các biến trong .env
    -> DB_DATABASE,DB_USERNAME,DB_PASSWORD,....(đã để mặc định)

7   -> php artisan migrate
    -> để tạo db

8   -> php artisan db:seed
    -> tạo dữ liệu từ fake -->

//////////////////////////////////////////////////////////////////////////

các câu lệnh khác

composer require laravel/socialite      -> tải socialite

npm run dev                             -> cập nhật css

npm run watch                           -> theo dõi css

php artisan storage:make
app/Console/Commands/StorageLinkCommand.php
config\filesystems.php
vendor\laravel\framework\src\Illuminate\Foundation\Console\StorageLinkCommand.php
rm public/storage
vendor\laravel\framework\src\Illuminate\Foundation\Console\ServeCommand.php
php artisan serve --port=8080
composer require jenssegers/mongodb --ignore-platform-reqs

///////////////////////

tải 
https://pecl.php.net/package/mongodb
-> chọn file có dll
chọn theo phiên bản php
tải về bỏ file dll vô php/ext/.
thêm extension= "tenfile".dll -> vào file php.ini