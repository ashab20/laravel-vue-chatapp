<?php

namespace App\Http\Controllers\Chat;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\Messages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class MessagesController extends Controller
{
    public function ChatBox($id):Response
    {
        $user_id = Auth()->user()->id;
        $messages = DB::table('messages')->where('room_id',$id)->latest()->get();
        $chatRoom = DB::table('chat_rooms')
        ->join('users as receiver', 'chat_rooms.reciever_id', '=', 'receiver.id')
        ->join('users as sender', 'chat_rooms.user_id', '=', 'sender.id')
        ->where(function ($query) use ($user_id) {
            $query->where('reciever_id', $user_id)
                  ->orWhere('user_id', $user_id);
        })
        ->select('receiver.name as receiver_name', 'sender.name as sender_name', 'chat_rooms.id')
        ->get();
        return Inertia::render('Chat/Room', [
            'messages'=>$messages,
            'room_id'=> $id ,
            'rooms'=>$chatRoom,
            'status' => session('status'),
        ]);

        // return response([
        //         'messages'=>$messages,
        //         'room_id'=> $id ,
        //         'rooms'=>$chatRoom,
        //         'status' => session('status'),
        //     ]);
    }

    public function GetMessages($id)
    {
        $user_id = Auth()->user()->id;
        $messages = DB::table('messages')->latest()->where('room_id',$id)->get();
        $chatRoom = DB::table('chat_rooms')
        ->join('users as receiver', 'chat_rooms.reciever_id', '=', 'receiver.id')
        ->join('users as sender', 'chat_rooms.user_id', '=', 'sender.id')
        ->where(function ($query) use ($user_id) {
            $query->where('reciever_id', $user_id)
                  ->orWhere('user_id', $user_id);
        })
        ->select('receiver.name as receiver_name', 'sender.name as sender_name', 'chat_rooms.id')
        ->get();
        // return Inertia::render('Chat/Room', [
        //     'messages'=>$messages,
        //     'room_id'=> $id ,
        //     'rooms'=>$chatRoom,
        //     'status' => session('status'),
        // ]);

        return response([
                'messages'=>$messages,
                'room_id'=> $id ,
                'rooms'=>$chatRoom,
                'status' => session('status'),
            ]);
    }


    public function SendMSG(Request $request)
    {
        $user_id = Auth()->user()->id;
        $room = ChatRoom::findOrFail($request->room_id);

        $reciever_id= null;

        // dd($room->sender_id);
        if($room->user_id != $user_id){
            $reciever_id = $room->user_id;
        }else{
            $reciever_id = $room->reciever_id;
        }


        $chat = new Messages();
        $chat->room_id = $request->room_id;
        $chat->message = $request->message;
        $chat->sender_id = $user_id;
        $chat->reciever_id = $reciever_id;
        $chat->save();

        broadcast(New SendMessage(Auth()->user(),$chat))->toOthers();

        return response($chat);
    // return Redirect::route('chats.ChatBox',$room->id);

   }
}