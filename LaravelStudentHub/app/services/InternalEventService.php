<?php
namespace App\Services;

use Illuminate\Http\Request;

class InternalEventService 
{
    public function getAll() {
        return InternalEvent::all();
    }
}