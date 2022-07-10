<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'content',
        'is_read',
        'un_read',
    ];

    public function conversations(){
        return $this->hasMany(ConversationMessage::class, 'id_message', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
