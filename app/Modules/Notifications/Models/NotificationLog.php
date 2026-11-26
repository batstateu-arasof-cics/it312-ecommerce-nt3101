<?php

namespace App\Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = ['user_id', 'template', 'channel', 'status', 'data', 'error'];

    protected $casts = ['data' => 'array'];
}
