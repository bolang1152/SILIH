@extends('layouts.app')

@section('content')
<div class="page-header-silih">
    <div class="page-header-content">
        <div class="page-title-wrapper">
            <div class="page-title-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="page-title">
                <h1>Item Borrowings</h1>
                <p class="page-subtitle">Kelola peminjaman barang</p>
            </div>
        </div>
        <div class="page-actions">
            <a href="{{ route('item_borrowings.create') }}" class="btn-silih btn-silih-info">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Pinjam Barang
            </a>
        </div>
    </div>
</div>

<div class="container-custom">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-silih alert-silih-success">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-info">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $borrowings->count() }}</span>
                <span class="stat-label">Total Borrowings</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-warning">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $borrowings->where('status', 'pending')->count() }}</span>
                <span class="stat-label">Menunggu</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-success">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $borrowings->where('status', 'completed')->count() }}</span>
                <span class="stat-label">Selesai</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-danger">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $borrowings->where('status', 'overdue')->count() }}</span>
                <span class="stat-label">Terlambat</span>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-silih">
        <div class="card-header-silih">
            <h3 class="card-title-silih">Daftar Item Borrowings</h3>
            <div class="card-actions">
                <div class="search-box-silih">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchBorrowings" placeholder="Cari borrowings..." class="search-input">
                </div>
            </div>
        </div>
        <div class="card-body-silih">
            @if($borrowings->count() > 0)
                <div class="table-responsive">
                    <table class="table-silih" id="borrowingsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pengguna</th>
                                <th>Item</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowings as $borrowing)
                                <tr>
                                    <td>
                                        <span class="item-id">#{{ $borrowing->id }}</span>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar-sm">{{ substr($borrowing->user->name ?? 'U', 0, 1) }}</div>
                                            <span>{{ $borrowing->user->name ?? 'User #' . $borrowing->user_id }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item-name">
                                            <div class="item-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                            {{ $borrowing->item->name ?? 'Item #' . $borrowing->item_id }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        @if($borrowing->status == 'completed')
                                            <span class="status-badge status-available">Selesai</span>
                                        @elseif($borrowing->status == 'pending')
                                            <span class="status-badge status-warning">Menunggu</span>
                                            @if(auth()->user()->is_admin)
                                            <div class="action-buttons mt-2">
                                                <form action="{{ route('admin.item_borrowings.approve', $borrowing->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-silih btn-silih-sm btn-silih-success">Setuju</button>
                                                </form>
                                                <form action="{{ route('admin.item_borrowings.reject', $borrowing->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-silih btn-silih-sm btn-silih-danger" onclick="return confirm('Tolak peminjaman ini?')">Tolak</button>
                                                </form>
                                            </div>
                                            @endif
                                        @elseif($borrowing->status == 'overdue')
                                            <span class="status-badge status-danger">Terlambat</span>
                                        @elseif($borrowing->status == 'borrowed')
                                            <span class="status-badge status-info">Dipinjam</span>
                                            @if(auth()->user()->is_admin)
                                            <div class="action-buttons mt-2">
                                                <form action="{{ route('admin.item_borrowings.return', $borrowing->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-silih btn-silih-sm btn-silih-primary" onclick="return confirm('Konfirmasi pengembalian item?')">Kembalikan</button>
                                                </form>
                                            </div>
                                            @endif
                                        @else
                                            <span class="status-badge">{{ $borrowing->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('item_borrowings.show', $borrowing->id) }}" class="btn-action btn-action-info" title="Lihat">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('item_borrowings.edit', $borrowing->id) }}" class="btn-action btn-action-warning" title="Edit">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('item_borrowings.destroy', $borrowing->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus borrowing ini?')">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3>Belum ada borrowings</h3>
                    <p>Mulai dengan meminjam barang pertama.</p>
                    <a href="{{ route('item_borrowings.create') }}" class="btn-silih btn-silih-info">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Pinjam Barang Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('searchBorrowings').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const table = document.getElementById('borrowingsTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        }
    });
</script>
@endpush
@endsection

