<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
      'user_id',
      'category_id',
      'title',
      'summary',
      'content',
    ];

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

}
