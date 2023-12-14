<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class BillDetail extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = "billdetail";
    protected $fillable = [
        "id_bill",
        "id_figure",
        "so_luong",
    ] ;
}
