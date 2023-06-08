<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $appends = ['image_url'];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }   
    
    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('images/products/'.$this->image);
    }

    // public function scopeWithFilters($query)
    // {
    //    return $query->when(request()->input('categories'), function($query){
    //         $query->whereIn('category_id', request()->input('categories'));
    //     })
    //     ->when(request()->input('sizes'), function($query){
    //         $query->whereIn('size_id', request()->input('sizes'));
    //     })        
    //     ->when(request()->input('colors'), function($query){
    //         $query->whereIn('color_id', request()->input('colors'));
    //     });
    // }

}
