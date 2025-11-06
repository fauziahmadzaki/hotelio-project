<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        
        return view('welcome', ['rooms'=> Room::where('room_status', 'available')->get()] );
    }
}
