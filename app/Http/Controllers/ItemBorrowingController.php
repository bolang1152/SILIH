<?php

namespace App\Http\Controllers;

use App\Models\ItemBorrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemBorrowingController extends Controller
{
    // Constructor dengan middleware auth
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Menampilkan daftar peminjaman barang
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->is_admin) {
            // Admin: lihat semua peminjaman
            $borrowings = ItemBorrowing::with(['user', 'item'])->latest()->get();
        } else {
            // User: lihat hanya peminjaman miliknya
            $borrowings = ItemBorrowing::with(['user', 'item'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }
        return view('item_borrowings.index', compact('borrowings'));
    }

    // Menampilkan form untuk membuat peminjaman barang
    public function create()
    {
        $items = Item::where('status', 'available')->get();
        return view('item_borrowings.create', compact('items'));
    }

    // Menyimpan peminjaman barang baru
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'borrowed_at' => 'required|date|after:now',
            'due_date' => 'required|date|after:borrowed_at',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($request->item_id);
        
        // Validasi quantity
        if ($request->quantity > $item->quantity) {
            return back()->with('error', 'Jumlah yang diminta melebihi stok tersedia (' . $item->quantity . ')')->withInput();
        }

        // User biasa hanya bisa pinjam untuk dirinya sendiri
        $userId = Auth::id();

        ItemBorrowing::create([
            'user_id' => $userId,
            'item_id' => $request->item_id,
            'borrowed_at' => $request->borrowed_at,
            'due_date' => $request->due_date,
            'quantity' => $request->quantity,
            'purpose' => $request->purpose,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('item_borrowings.index')->with('success', 'Peminjaman barang berhasil diajukan. Menunggu persetujuan admin.');
    }

    // Menampilkan detail peminjaman
    public function show($id)
    {
        $borrowing = ItemBorrowing::with(['user', 'item'])->findOrFail($id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // User hanya bisa melihat borrowing miliknya
        if (!$user->is_admin && $borrowing->user_id !== $user->id) {
            return redirect()->route('item_borrowings.index')->with('error', 'Anda tidak memiliki akses ke peminjaman ini.');
        }
        
        return view('item_borrowings.show', compact('borrowing'));
    }

    // Mengupdate peminjaman barang
    public function update(Request $request, $id)
    {
        $borrowing = ItemBorrowing::findOrFail($id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // User hanya bisa update borrowing miliknya, dan hanya jika status pending
        if (!$user->is_admin) {
            if ($borrowing->user_id !== $user->id) {
                return redirect()->route('item_borrowings.index')->with('error', 'Anda tidak memiliki akses.');
            }
            if ($borrowing->status !== 'pending') {
                return redirect()->route('item_borrowings.index')->with('error', 'Peminjaman yang sudah diproses tidak dapat diubah.');
            }
        }

        $request->validate([
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after:borrowed_at',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required|string|max:255',
        ]);

        $borrowing->update([
            'borrowed_at' => $request->borrowed_at,
            'due_date' => $request->due_date,
            'quantity' => $request->quantity,
            'purpose' => $request->purpose,
        ]);

        return redirect()->route('item_borrowings.index')->with('success', 'Peminjaman barang berhasil diperbarui.');
    }

    // Menghapus peminjaman barang
    public function destroy($id)
    {
        $borrowing = ItemBorrowing::findOrFail($id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Hanya admin atau owner yang bisa hapus
        if (!$user->is_admin && $borrowing->user_id !== $user->id) {
            return redirect()->route('item_borrowings.index')->with('error', 'Anda tidak memiliki akses.');
        }
        
        $borrowing->delete();

        return redirect()->route('item_borrowings.index')->with('success', 'Peminjaman barang berhasil dihapus.');
    }

    // APPROVE - Hanya untuk Admin
    public function approve(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->is_admin) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses.');
        }

        $borrowing = ItemBorrowing::findOrFail($id);
        
        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses.');
        }

        $item = Item::findOrFail($borrowing->item_id);
        
        // Validasi stok
        if ($borrowing->quantity > $item->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        // Kurangi stok
        $item->decrement('quantity', $borrowing->quantity);
        
        // Update status borrowing
        $borrowing->update(['status' => 'borrowed']);

        return redirect()->back()->with('success', 'Peminjaman barang telah disetujui.');
    }

    // REJECT - Hanya untuk Admin
    public function reject(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->is_admin) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses.');
        }

        $borrowing = ItemBorrowing::findOrFail($id);
        
        if ($borrowing->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses.');
        }

        $borrowing->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason ?? 'Tidak disebutkan'
        ]);

        return redirect()->back()->with('success', 'Peminjaman barang telah ditolak.');
    }

    // RETURN - Hanya untuk Admin (mengembalikan item)
    public function returnItem(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->is_admin) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses.');
        }

        $borrowing = ItemBorrowing::findOrFail($id);
        
        if ($borrowing->status !== 'borrowed') {
            return redirect()->back()->with('error', 'Item belum dipinjam atau sudah dikembalikan.');
        }

        $item = Item::findOrFail($borrowing->item_id);
        
        // Kembalikan stok
        $item->increment('quantity', $borrowing->quantity);
        
        // Update status borrowing
        $borrowing->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Item telah dikembalikan dan stok diperbarui.');
    }
}

