<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Eloquent
{
    use HasFactory,SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = "bills";
    protected $fillable = [
        "dia_chi",
        "so_dien_thoai",
        "thoi_gian_thanh_toan",
        "thoi_gian_giao_hang",
        "trang_thai",
        "id_user",
        "hinh_anh",
        "tong_tien",
        "phuong_thuc_thanh_toan",
        "cardIDs",
        "da_thanh_toan"
    ] ;
}
