<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        
        return view('welcome', ['rooms'=> Room::where('room_status', 'available')->get()] );
    }
    public function rooms(Request $request){
       $sort = $request->get('sort', 'termurah');

        // Query dasar hanya untuk kamar yang tersedia
        $query = Room::where('room_status', 'available');

        // Terapkan urutan berdasarkan pilihan filter
        switch ($sort) {
            case 'termahal':
                $query->orderBy('room_price', 'desc');
                break;

            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;

            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;

            case 'termurah':
            default:
                $query->orderBy('room_price', 'asc');
                break;
        }

        $rooms = $query->get();

        return view('room', [
            'rooms' => $rooms,
            'sort'  => $sort, // bisa dipakai di view untuk menampilkan status filter aktif
        ]);

    }
}
