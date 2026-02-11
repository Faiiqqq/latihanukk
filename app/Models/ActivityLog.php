<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'role',
        'aksi',
        'deskripsi',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
