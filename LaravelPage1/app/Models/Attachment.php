<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = "Attachments";
    protected $primaryKey = "Id";

    const CREATED_AT = "CreationDateTime";
    const UPDATED_AT = "EditDateTime";
}