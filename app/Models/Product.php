<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'image', 'price', 'description','category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
 // yo code ma slug generate garney code ho
    public  static function boot(){
        parent::boot();
        static::creating(function($product){
            $product->slug=Str::slug($product->name);
        });

    }

}
