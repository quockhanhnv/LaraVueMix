<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notifications', 'notification_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
