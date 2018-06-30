<?php

namespace CodeShopping\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    protected $fillable = ['product_id', 'file_name'];
}
