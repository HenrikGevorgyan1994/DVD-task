<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
   protected $fillable = ['category_id', 'name'];

   public function Category()
   {
       return $this->belongsTo("App\Category");
   }


   public function Product()
   {
       return $this->hasMany("App\Products");
   }
}
