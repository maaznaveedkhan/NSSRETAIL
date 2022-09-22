<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function quantity(){
        return $this->hasMany(StockQuantity::class,'item_id','id');
    }
}
