web demo https://weepooshop.000webhostapp.com/
video demo https://drive.google.com/file/d/1fLBedlRiHYQ3Ro20EPUEWkSI3MHFuTTI/view?usp=drive_link


----------------  Các câu lệnh cần chạy sau khi clone  --------------------/

composer install --ignore-platform-reqs
cp .env.example .env
php artisan key:generate

---------------------------------------------------------------------------/

----------------  Nếu máy chưa hỗ trợ mongodb trong xampp  --------------------/

1   -> https://pecl.php.net/package/mongodb
2   -> chọn file có hỗ trợ file dll
3   -> chọn phiên bản php phù hợp
<!-- có thể vào xampp -> config aphache -> để thấy thư mục php -->
4   -> copy file mongo.dll vào php/ext/.
5   -> thêm --- extension= "tenfile".dll -- 
    -> vào file php.ini

---------------------------------------------------------------------------/

--------------------  Giải thích 1 số câu lệnh  ---------------------------/

1   -> composer install --ignore-platform-reqs
    -> tải mà bỏ qua các yêu cầu phiên bản

2   -> cp .env.example .env
    -> copy file env trên weepoo
    -> https://bom.so/envweepoo

3   -> php artisan key:generate
    -> sinh APP_KEY trong .env

---------------------------------------------------------------------------/


-------------------------- Các câu lệnh khác  -----------------------------/

1   -> npm install
    -> hỗ trợ làm web, các thư viện được tải xuống từ npm

2   -> php artisan storage:link
    -> tạo 1 short cut từ storage qua public

3   -> php artisan migrate
    -> để tạo database

4   -> php artisan db:seed
    -> tạo dữ liệu từ ảo từ thư viện faker

---------------------------------------------------------------------------/

--------------- 1 số câu lệnh đã dùng trong lúc tạo  ----------------------/

composer require laravel/socialite      -> tải socialite

php artisan serve --port=8080           -> tùy chỉnh port lúc tạo server

npm run dev                             -> cập nhật css

npm run watch                           -> theo dõi css

php artisan storage:make                -> tạo storge

rm public/storage                       -> gỡ liên kết storge vs public

php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider" --tag="cloudinary-laravel-config"
                                        -> public file config cloudinary vào folder config

composer require jenssegers/mongodb --ignore-platform-reqs
                                        -> tải mongo (đã không hỗ trợ phiên bản)

https://github.com/cloudinary-devs/cloudinary-laravel
                                        -> các thứ hỗ trợ cloudinary

---------------------------------------------------------------------------/
