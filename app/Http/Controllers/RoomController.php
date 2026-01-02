<?php
// app/Http/Controllers/RoomController.php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Menampilkan daftar ruangan
    public function index()
    {
        $rooms = Room::all();  // Ambil semua ruangan
        return view('rooms.index', compact('rooms'));  // Kirim data ke view
    }

    // Menampilkan form untuk menambah ruangan baru
    public function create()
    {
        return view('rooms.create');
    }

    // Menyimpan ruangan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        Room::create([
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit ruangan
    public function edit($id)
    {
        $room = Room::findOrFail($id);  // Cari ruangan berdasarkan ID
        return view('rooms.edit', compact('room'));
    }

    // Mengupdate data ruangan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($id);
        $room->update([
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil diubah.');
    }

    // Menghapus ruangan
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
