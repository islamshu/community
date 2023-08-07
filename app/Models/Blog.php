<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    public function keywords()
    {
        return $this->belongsToMany(KeyWord::class, 'blog_keywords','blog_id', 'keyword_id');
    }
    /**
     * Get the user associated with the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image_blog()
    {
        return $this->belongsTo(BlogImage::class,'image_id');
    }
    /**
     * Get the user that owns the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Admin::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
