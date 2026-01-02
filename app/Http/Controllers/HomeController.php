<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\ItemBorrowing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }

    public function adminDashboard()
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses admin.');
        }

        $stats = [
            'total_items' => Item::count(),
            'available_items' => Item::where('status', 'available')->count(),
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'total_bookings' => RoomBooking::count(),
            'pending_bookings' => RoomBooking::where('status', 'pending')->count(),
            'approved_bookings' => RoomBooking::where('status', 'approved')->count(),
            'total_borrowings' => ItemBorrowing::count(),
            'pending_borrowings' => ItemBorrowing::where('status', 'pending')->count(),
            'borrowed_borrowings' => ItemBorrowing::where('status', 'borrowed')->count(),
            'total_users' => User::where('is_admin', false)->count(),
        ];

        $recent_items = Item::latest()->take(5)->get();
        $recent_rooms = Room::latest()->take(5)->get();
        $pending_bookings = RoomBooking::with(['user', 'room'])->where('status', 'pending')->latest()->take(5)->get();
        $pending_borrowings = ItemBorrowing::with(['user', 'item'])->where('status', 'pending')->latest()->take(5)->get();
        $recent_users = User::where('is_admin', false)->latest()->take(5)->get();

        return view('home', compact(
            'stats',
            'recent_items',
            'recent_rooms',
            'pending_bookings',
            'pending_borrowings',
            'recent_users'
        ))->with('is_admin', true);
    }

    public function userDashboard()
    {
        $userId = Auth::id();

        $stats = [
            'my_bookings' => RoomBooking::where('user_id', $userId)->count(),
            'my_pending_bookings' => RoomBooking::where('user_id', $userId)->where('status', 'pending')->count(),
            'my_approved_bookings' => RoomBooking::where('user_id', $userId)->where('status', 'approved')->count(),
            'my_borrowings' => ItemBorrowing::where('user_id', $userId)->count(),
            'my_pending_borrowings' => ItemBorrowing::where('user_id', $userId)->where('status', 'pending')->count(),
            'my_borrowed_items' => ItemBorrowing::where('user_id', $userId)->where('status', 'borrowed')->count(),
        ];

        $my_bookings = RoomBooking::with(['room'])->where('user_id', $userId)->latest()->take(5)->get();
        $my_borrowings = ItemBorrowing::with(['item'])->where('user_id', $userId)->latest()->take(5)->get();
        $available_items = Item::where('status', 'available')->take(5)->get();
        $available_rooms = Room::where('status', 'available')->take(5)->get();

        return view('home', compact(
            'stats',
            'my_bookings',
            'my_borrowings',
            'available_items',
            'available_rooms'
        ))->with('is_user', true);
    }
}
