<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'url'
    ];

    //for route model binding
    public function getRouteKeyName()
    {
        return 'url';
    }

    //HAS MANY
    public function articles() {
        return $this->hasMany(Article::class);
    }
}
