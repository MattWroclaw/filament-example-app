<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "slug",
        "category_id",
        "thumbnail",
        "content",
        "tag",
        "color",
        "published",
    ];

    protected $casts = [
        'tag' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->belongsToMany(User::class, 'post_user')->withTimestamps();
    }
}
