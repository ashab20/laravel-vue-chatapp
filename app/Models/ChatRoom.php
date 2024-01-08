<?php

namespace App\Models;

use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    function message(){
        return $this->belongsToMany(Message::class,'id','room_id');
    }

    function user(){
        return $this->belongsTo(User::class,'reciever_id','id');
    }
}