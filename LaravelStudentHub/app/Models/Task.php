<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'Tasks';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Title',
        'IsDone',
        'StartDateTime',
        'Description',
        'Deadline',
        'InternalEventId',
        'CreationDateTime',
        'EditDateTime',
        'Notes',
        'IsActive'
    ];

    protected $casts = [
        'IsDone' => 'boolean',
        'IsActive' => 'boolean',
        'StartDateTime' => 'datetime',
        'Deadline' => 'datetime',
        'CreationDateTime' => 'datetime',
        'EditDateTime' => 'datetime',
    ];

    public function internalEvent()
    {
        return $this->belongsTo(InternalEvent::class, 'InternalEventId', 'Id');
    }
}
