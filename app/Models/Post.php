<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        "title",
        "category_id",
        "posted_by",
        "content",
    ];

    public function category()
    {
        return $this->belongsTo("App\Models\Category", "category_id", "id");
    }
    public function user()
    {
        return $this->belongsTo("App\User", "posted_by", "id");
    }
}
