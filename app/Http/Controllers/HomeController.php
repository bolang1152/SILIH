<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\ItemBorrowing;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stats = [
            'total_items' => Item::count(),
            'available_items' => Item::where('status', 'available')->count(),
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'total_bookings' => RoomBooking::count(),
            'pending_bookings' => RoomBooking::where('status', 'pending')->count(),
            'total_borrowings' => ItemBorrowing::count(),
            'pending_borrowings' => ItemBorrowing::where('status', 'pending')->count(),
        ];

        $recent_items = Item::latest()->take(5)->get();
        $recent_rooms = Room::latest()->take(5)->get();
        $recent_bookings = RoomBooking::latest()->take(5)->get();
        $recent_borrowings = ItemBorrowing::latest()->take(5)->get();

        return view('home', compact('stats', 'recent_items', 'recent_rooms', 'recent_bookings', 'recent_borrowings'));
    }
}
