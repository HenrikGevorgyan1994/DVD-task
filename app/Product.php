<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Category;
class Product extends Model
{

    protected $casts = ['file' => 'array','category_id' => 'array'];
    
    protected $fillable = ["category_id", "subcategory_id", "case_count", "name", "description" , "brand", "size", "file","upc"];


    public function SubCategoryProduct()
    {
        return $this->hasOne("App\SubCategory","id", "subcategory_id");
    }


    public function CategoryProduct()
    {
        return $this->hasMany("App\Category");
        
    }

   
}
