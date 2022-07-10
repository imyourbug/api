<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'avatar',
        'link',
        'task'
    ];

    public function messages(){
        return $this->hasMany(ConversationMessage::class, 'id_conversation', 'id');
    }

    public function conversations(){
        return $this->hasMany(ConversationSetting::class, 'id_conversation', 'id');
    }
}
