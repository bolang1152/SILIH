<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomBookingController extends Controller
{
    // Constructor dengan middleware auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan daftar pemesanan ruangan
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->is_admin) {
            // Admin: lihat semua pemesanan
            $bookings = RoomBooking::with(['user', 'room'])->latest()->get();
        } else {
            // User: lihat hanya pemesanan miliknya
            $bookings = RoomBooking::with(['user', 'room'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }
        return view('room_bookings.index', compact('bookings'));
    }

    // Menampilkan form untuk membuat pemesanan ruangan baru
    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        return view('room_bookings.create', compact('rooms'));
    }

    // Menyimpan pemesanan ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string|max:255',
        ]);

        // User biasa hanya bisa booking untuk dirinya sendiri
        $userId = Auth::id();

        RoomBooking::create([
            'user_id' => $userId,
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('room_bookings.index')->with('success', 'Pemesanan ruangan berhasil diajukan. Menunggu persetujuan admin.');
    }

    // Menampilkan detail pemesanan
    public function show($id)
    {
        $booking = RoomBooking::with(['user', 'room'])->findOrFail($id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // User hanya bisa melihat booking miliknya
        if (!$user->is_admin && $booking->user_id !== $user->id) {
            return redirect()->route('room_bookings.index')->with('error', 'Anda tidak memiliki akses ke pemesanan ini.');
        }
        
        return view('room_bookings.show', compact('booking'));
    }

    // Mengupdate pemesanan ruangan
    public function update(Request $request, $id)
    {
        $booking = RoomBooking::findOrFail($id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // User hanya bisa update booking miliknya, dan hanya jika status pending
        if (!$user->is_admin) {
            if ($booking->user_id !== $user->id) {
                return redirect()->route('room_bookings.index')->with('error', 'Anda tidak memiliki akses.');
            }
            if ($booking->status !== 'pending') {
                return redirect()->route('room_bookings.index')->with('error', 'Pemesanan yang sudah diproses tidak dapat diubah.');
            }
        }

        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string|max:255',
        ]);

        $booking->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
        ]);

        return redirect()->route('room_bookings.index')->with('success', 'Pemesanan ruangan berhasil diperbarui.');
    }

    // Menghapus pemesanan ruangan
    public function destroy($id)
    {
        $booking = RoomBooking::findOrFail($id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Hanya admin atau owner yang bisa hapus
        if (!$user->is_admin && $booking->user_id !== $user->id) {
            return redirect()->route('room_bookings.index')->with('error', 'Anda tidak memiliki akses.');
        }
        
        $booking->delete();

        return redirect()->route('room_bookings.index')->with('success', 'Pemesanan ruangan berhasil dihapus.');
    }

    // APPROVE - Hanya untuk Admin
    public function approve(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->is_admin) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses.');
        }

        $booking = RoomBooking::findOrFail($id);
        
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Pemesanan sudah diproses.');
        }

        $booking->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Pemesanan ruangan telah disetujui.');
    }

    // REJECT - Hanya untuk Admin
    public function reject(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->is_admin) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses.');
        }

        $booking = RoomBooking::findOrFail($id);
        
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Pemesanan sudah diproses.');
        }

        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason ?? 'Tidak disebutkan'
        ]);

        return redirect()->back()->with('success', 'Pemesanan ruangan telah ditolak.');
    }
}

