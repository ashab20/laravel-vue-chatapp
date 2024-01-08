<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CreateRoomController extends Controller
{

    public function getUsers():Response
    {
        $users  = DB::table('users')->select('name','id')->get();

        return response(['users'=>$users],200);
    }

}