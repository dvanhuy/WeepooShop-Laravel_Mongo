<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Figure extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = "figures";
    protected $fillable = [
        'ten',
        'gia',
        'so_luong_hien_con',
        'so_luong_da_ban',
        'nha_sx',
        'chieu_cao',
        'chieu_rong',
        'chieu_dai',
        'chat_lieu',
        'mo_ta',
        'hinh_anh',
    ];
}
