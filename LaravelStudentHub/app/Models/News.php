<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'description',
        'publish_from',
        'publish_until',
        'user_id',
    ];

    protected $casts = [
        'publish_from' => 'datetime',
        'publish_until' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
