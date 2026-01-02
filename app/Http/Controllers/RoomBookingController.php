<?php
// app/Http/Controllers/RoomBookingController.php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use Illuminate\Http\Request;

class RoomBookingController extends Controller
{
    // Menampilkan daftar pemesanan ruangan
    public function index()
    {
        $bookings = RoomBooking::all();  // Ambil semua pemesanan ruangan
        return view('room_bookings.index', compact('bookings'));
    }

    // Menampilkan form untuk membuat pemesanan ruangan baru
    public function create()
    {
        return view('room_bookings.create');
    }

    // Menyimpan pemesanan ruangan baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        RoomBooking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending',
        ]);

        return redirect()->route('room_bookings.index')->with('success', 'Pemesanan ruangan berhasil.');
    }

    // Mengupdate pemesanan ruangan
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $booking = RoomBooking::findOrFail($id);
        $booking->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        return redirect()->route('room_bookings.index')->with('success', 'Pemesanan ruangan berhasil diperbarui.');
    }

    // Menghapus pemesanan ruangan
    public function destroy($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->delete();

        return redirect()->route('room_bookings.index')->with('success', 'Pemesanan ruangan berhasil dihapus.');
    }
}

