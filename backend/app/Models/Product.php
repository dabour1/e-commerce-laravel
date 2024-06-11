<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return url('storage/images/products/' . $this->image);
    }
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

     
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }
}
