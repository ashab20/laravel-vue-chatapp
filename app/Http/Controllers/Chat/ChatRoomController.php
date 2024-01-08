<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ChatRoomController extends Controller
{
    public function chatRoomList():Response
    {

        $user_id = Auth()->user()->id;

        $chatRoom = DB::table('chat_rooms')
        ->join('users as receiver', 'chat_rooms.reciever_id', '=', 'receiver.id')
        ->join('users as sender', 'chat_rooms.user_id', '=', 'sender.id')
        ->where(function ($query) use ($user_id) {
            $query->where('reciever_id', $user_id)
                  ->orWhere('user_id', $user_id);
        })
        ->select('receiver.name as receiver_name', 'sender.name as sender_name', 'chat_rooms.id')
        ->get();




        $users = DB::table('users')
                ->whereNot('id',$user_id)
                ->get();

        // dd($chatRoom);
        return Inertia::render('Chat/Room', [
            'rooms'=>$chatRoom,
            'users' => $users,
            'status' => session('status'),
        ]);
    }


    public function CreateChatRoom():Response
    {

        $user_id = Auth()->user()->id;
        $chatRoom = ChatRoom::where('user_id',$user_id);
        $users = User::get();
        // dd($chatRoom);
        return Inertia::render('Chat/Room', [
            'rooms'=>$chatRoom,
            'users' => $users,
            'status' => session('status'),
        ]);
   }


   public function ChatRoomStore(Request $request):RedirectResponse
   {

    $user_id = Auth()->user()->id;

    $room = new ChatRoom();
    $room->reciever_id = $request->reciever_id;
    $room->user_id = $user_id;
    $room->status = 1;
    if($room->save()){
        $chat = new Messages();
        $chat->room_id = $room->id;
        $chat->message = $request->message;
        $chat->sender_id = $user_id;
        $chat->reciever_id = $request->reciever_id;
        $chat->save();
    };


    return Redirect::route('chats.list');
   }
}