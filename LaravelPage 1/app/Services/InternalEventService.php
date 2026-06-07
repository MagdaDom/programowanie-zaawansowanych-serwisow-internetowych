<?php

namespace App\Services;

use App\Models\InternalEvent;
use Illuminate\Http\Request;

class InternalEventService 
{
    public function getAll() {
        return InternalEvent::all();
    }
}