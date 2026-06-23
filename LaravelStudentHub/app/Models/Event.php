<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'html_content',
        'image_path',
        'event_date',
        'publish_from',
        'publish_until',
        'requires_registration',
        'max_participants',
        'recurrence',
        'user_id',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'publish_from' => 'datetime',
        'publish_until' => 'datetime',
        'requires_registration' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
