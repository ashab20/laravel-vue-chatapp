<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    function room(){
        return $this->hasMany(ChatRoom::class,'room_id','id');
    }

    function sender(){
        return $this->hasMany(User::class,'sender_id','id');
    }

    function reciever(){
        return $this->hasMany(User::class,'reciever_id','id');
    }
}