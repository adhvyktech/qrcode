<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicQRCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'key',
        'redirect_url',
        'active_from',
        'active_to',
        'style',
    ];

    protected $casts = [
        'active_from' => 'datetime',
        'active_to' => 'datetime',
        'style' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}