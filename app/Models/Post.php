<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thinks',
        'image_url'
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'tag_post', 'post_id', 'tag_id');
    }
}
