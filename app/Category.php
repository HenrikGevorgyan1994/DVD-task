<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    protected $fillable = ['product_id','name'];

    public function SubCategory()
    {
        return $this->hasMany("App\SubCategory");
    }

    public function Product()
    {
        return $this->hasOne("App\Product",'id','product_id');
    }
}
