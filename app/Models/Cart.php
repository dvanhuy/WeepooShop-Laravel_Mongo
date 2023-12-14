<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Cart extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = "cartstore";
    protected $fillable = [
        "id_user",
        "id_figure",
        "so_luong",
    ] ;
}
