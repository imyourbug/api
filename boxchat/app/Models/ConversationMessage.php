<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_message',
        'id_conversation'
    ];

    public function message(){
        return $this->belongsTo(Message::class, 'id_message', 'id');
    }

    public function conversation(){
        return $this->belongsTo(Conversation::class, 'id_conversation', 'id');
    }
}
