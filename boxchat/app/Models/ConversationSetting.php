<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_conversation',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'id_conversation', 'id');
    }
}
