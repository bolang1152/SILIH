@extends('layouts.app')

@section('content')
<div class="page-header-silih">
    <div class="page-header-content">
        <div class="page-title-wrapper">
            <div class="page-title-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="page-title">
                <h1>Items</h1>
                <p class="page-subtitle">Kelola inventaris barang peminjaman</p>
            </div>
        </div>
        <div class="page-actions">
            <a href="{{ route('items.create') }}" class="btn-silih btn-silih-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Item
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
            <div class="stat-icon stat-icon-primary">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $items->count() }}</span>
                <span class="stat-label">Total Items</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-success">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $items->where('status', 'available')->count() }}</span>
                <span class="stat-label">Tersedia</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-warning">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $items->where('status', 'borrowed')->count() }}</span>
                <span class="stat-label">Dipinjam</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-danger">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $items->sum('quantity') }}</span>
                <span class="stat-label">Total Stok</span>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-silih">
        <div class="card-header-silih">
            <h3 class="card-title-silih">Daftar Items</h3>
            <div class="card-actions">
                <div class="search-box-silih">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchItems" placeholder="Cari items..." class="search-input">
                </div>
            </div>
        </div>
        <div class="card-body-silih">
            @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table-silih" id="itemsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Item</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        <span class="item-id">#{{ $item->id }}</span>
                                    </td>
                                    <td>
                                        <div class="item-name">
                                            <div class="item-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                            {{ $item->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="item-description">{{ Str::limit($item->description, 40) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-silih badge-silih-outline">{{ $item->quantity }} unit</span>
                                    </td>
                                    <td>
                                        @if($item->status == 'available')
                                            <span class="status-badge status-available">Tersedia</span>
                                        @elseif($item->status == 'borrowed')
                                            <span class="status-badge status-warning">Dipinjam</span>
                                        @else
                                            <span class="status-badge status-danger">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('items.show', $item->id) }}" class="btn-action btn-action-info" title="Lihat">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('items.edit', $item->id) }}" class="btn-action btn-action-warning" title="Edit">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
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
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3>Belum ada items</h3>
                    <p>Mulai dengan menambahkan item pertama untuk inventaris Anda.</p>
                    <a href="{{ route('items.create') }}" class="btn-silih btn-silih-primary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Item Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Simple search functionality
    document.getElementById('searchItems').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const table = document.getElementById('itemsTable');
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

