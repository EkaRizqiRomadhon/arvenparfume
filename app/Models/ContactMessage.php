<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    // Hanya menyimpan created_at; kolom updated_at tidak digunakan.
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'ip_address',
        'status',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }
}
