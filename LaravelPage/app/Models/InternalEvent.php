<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalEvent extends Model
{
    protected $table = 'internalevents';
    protected $primaryKey = 'Id';
    public $timestamps = false;

        protected $fillable = [
            'Title',
            'Link',
            'IsPublic',
            'IsCancelled',
            'EventDateTime',
            'PublishDateTime',
            'ShortDescription',
            'ContentHTML',
            'MetaDescription',
            'MetaTags',
            'CreationDateTime',
            'EditDateTime',
            'Notes',
            'IsActive'
        ];

        protected $casts = [
            'IsPublic' => 'boolean',
            'IsCancelled' => 'boolean',
            'IsActive' => 'boolean',
            'EventDateTime' => 'datetime',
            'PublishDateTime' => 'datetime',
            'CreationDateTime' => 'datetime',
            'EditDateTime' => 'datetime',
        ];


    public function tasks()
    {
        return $this->hasMany(Task::class, 'InternalEventId', 'Id');
    }
}
