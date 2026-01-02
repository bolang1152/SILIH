<?php
// app/Http/Controllers/ItemBorrowingController.php

namespace App\Http\Controllers;

use App\Models\ItemBorrowing;
use Illuminate\Http\Request;

class ItemBorrowingController extends Controller
{
    // Menampilkan daftar peminjaman barang
    public function index()
    {
        $borrowings = ItemBorrowing::all();  // Ambil semua peminjaman barang
        return view('item_borrowings.index', compact('borrowings'));
    }

    // Menampilkan form untuk membuat peminjaman barang
    public function create()
    {
        return view('item_borrowings.create');
    }

    // Menyimpan peminjaman barang baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'item_id' => 'required|exists:items,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after:borrowed_at',
        ]);

        ItemBorrowing::create([
            'user_id' => $request->user_id,
            'item_id' => $request->item_id,
            'borrowed_at' => $request->borrowed_at,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        return redirect()->route('item_borrowings.index')->with('success', 'Peminjaman barang berhasil.');
    }

    // Mengupdate peminjaman barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,overdue',
        ]);

        $borrowing = ItemBorrowing::findOrFail($id);
        $borrowing->update([
            'status' => $request->status,
        ]);

        return redirect()->route('item_borrowings.index')->with('success', 'Status peminjaman barang berhasil diperbarui.');
    }

    // Menghapus peminjaman barang
    public function destroy($id)
    {
        $borrowing = ItemBorrowing::findOrFail($id);
        $borrowing->delete();

        return redirect()->route('item_borrowings.index')->with('success', 'Peminjaman barang berhasil dihapus.');
    }
}

