@extends('layouts.app')

@php
$isAdmin = auth()->user()->is_admin;
@endphp

@section('content')
<div class="page-header-silih {{ $isAdmin ? 'page-header-admin' : 'page-header-user' }}">
    <div class="page-header-content">
        <div class="page-title-wrapper">
            <div class="page-title-icon">
                @if($isAdmin)
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                @else
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                @endif
            </div>
            <div class="page-title">
                @if($isAdmin)
                <h1>Dashboard Admin</h1>
                <p class="page-subtitle">Kelola seluruh sistem SILIH</p>
                @else
                <h1>Dashboard Saya</h1>
                <p class="page-subtitle">Pantau peminjaman Anda di SILIH</p>
                @endif
            </div>
        </div>
        <div class="page-actions">
            @if($isAdmin)
            <a href="{{ route('items.create') }}" class="btn-silih btn-silih-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Item
            </a>
            <a href="{{ route('rooms.create') }}" class="btn-silih btn-silih-success">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Room
            </a>
            @else
            <a href="{{ route('room_bookings.create') }}" class="btn-silih btn-silih-warning">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Booking Room
            </a>
            <a href="{{ route('item_borrowings.create') }}" class="btn-silih btn-silih-info">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pinjam Item
            </a>
            @endif
        </div>
    </div>
</div>

<div class="container-custom">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert-silih alert-silih-success">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-silih alert-silih-danger">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if($isAdmin)
    <!-- ==================== ADMIN DASHBOARD ==================== -->
    <!-- Stats Grid - Admin -->
    <div class="stats-grid">
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-primary">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_items'] ?? 0 }}</span>
                <span class="stat-label">Total Items</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-success">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_rooms'] ?? 0 }}</span>
                <span class="stat-label">Total Rooms</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-warning">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['pending_bookings'] ?? 0 }}</span>
                <span class="stat-label">Booking Pending</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-info">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['pending_borrowings'] ?? 0 }}</span>
                <span class="stat-label">Peminjaman Pending</span>
            </div>
        </div>
    </div>

    <!-- Two Column Layout for Admin -->
    <div class="dashboard-grid">
        <!-- Pending Approvals Column -->
        <div class="dashboard-column">
            <!-- Pending Room Bookings -->
            @if(isset($pending_bookings) && $pending_bookings->count() > 0)
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Persetujuan Room Booking
                    </h3>
                    <span class="badge-silih badge-silih-warning">{{ $pending_bookings->count() }} pending</span>
                </div>
                <div class="card-body-silih p-0">
                    <div class="approval-list">
                        @foreach($pending_bookings as $booking)
                        <div class="approval-item">
                            <div class="approval-info">
                                <div class="approval-title">{{ $booking->room->name ?? 'Room' }}</div>
                                <div class="approval-meta">
                                    {{ $booking->user->name }} | {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="approval-actions">
                                <form action="{{ route('admin.room_bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-action-success" title="Setujui">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.room_bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-action-danger" title="Tolak" onclick="return confirm('Tolak booking ini?')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Pending Item Borrowings -->
            @if(isset($pending_borrowings) && $pending_borrowings->count() > 0)
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Persetujuan Peminjaman
                    </h3>
                    <span class="badge-silih badge-silih-warning">{{ $pending_borrowings->count() }} pending</span>
                </div>
                <div class="card-body-silih p-0">
                    <div class="approval-list">
                        @foreach($pending_borrowings as $borrowing)
                        <div class="approval-item">
                            <div class="approval-info">
                                <div class="approval-title">{{ $borrowing->item->name ?? 'Item' }} ({{ $borrowing->quantity }})</div>
                                <div class="approval-meta">
                                    {{ $borrowing->user->name }} | Tgl: {{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d/m/Y') }}
                                </div>
                            </div>
                            <div class="approval-actions">
                                <form action="{{ route('admin.item_borrowings.approve', $borrowing->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-action-success" title="Setujui">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.item_borrowings.reject', $borrowing->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-action-danger" title="Tolak" onclick="return confirm('Tolak peminjaman ini?')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Recent Data Column -->
        <div class="dashboard-column">
            <!-- Recent Items -->
            @if(isset($recent_items) && $recent_items->count() > 0)
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">Items Terbaru</h3>
                    <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
                </div>
                <div class="card-body-silih p-0">
                    <div class="list-group">
                        @foreach($recent_items as $item)
                        <div class="list-group-item">
                            <div class="d-flex justify-between align-center">
                                <div>
                                    <strong>{{ $item->name }}</strong>
                                    <br><small class="text-muted">{{ $item->quantity }} unit</small>
                                </div>
                                @if($item->status == 'available')
                                    <span class="badge-silih badge-silih-success">Tersedia</span>
                                @else
                                    <span class="badge-silih badge-silih-warning">Dipinjam</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Rooms -->
            @if(isset($recent_rooms) && $recent_rooms->count() > 0)
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">Rooms Terbaru</h3>
                    <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-outline">Lihat Semua</a>
                </div>
                <div class="card-body-silih p-0">
                    <div class="list-group">
                        @foreach($recent_rooms as $room)
                        <div class="list-group-item">
                            <div class="d-flex justify-between align-center">
                                <div>
                                    <strong>{{ $room->name }}</strong>
                                    <br><small class="text-muted">Kapasitas: {{ $room->capacity }} orang</small>
                                </div>
                                @if($room->status == 'available')
                                    <span class="badge-silih badge-silih-success">Tersedia</span>
                                @else
                                    <span class="badge-silih badge-silih-danger">Maintenance</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @else
    <!-- ==================== USER DASHBOARD ==================== -->
    <!-- Stats Grid - User -->
    <div class="stats-grid">
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-warning">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['my_pending_bookings'] ?? 0 }}</span>
                <span class="stat-label">Booking Pending</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-success">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['my_approved_bookings'] ?? 0 }}</span>
                <span class="stat-label">Booking Disetujui</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-info">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['my_pending_borrowings'] ?? 0 }}</span>
                <span class="stat-label">Peminjaman Pending</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-danger">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['my_borrowed_items'] ?? 0 }}</span>
                <span class="stat-label">Sedang Dipinjam</span>
            </div>
        </div>
    </div>

    <!-- My Bookings and Borrowings -->
    <div class="dashboard-grid">
        <div class="dashboard-column">
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">Room Bookings Saya</h3>
                    <a href="{{ route('room_bookings.create') }}" class="btn btn-sm btn-silih-primary">Booking Baru</a>
                </div>
                <div class="card-body-silih p-0">
                    @if(isset($my_bookings) && $my_bookings->count() > 0)
                        <div class="list-group">
                            @foreach($my_bookings as $booking)
                            <div class="list-group-item">
                                <div class="d-flex justify-between align-center">
                                    <div>
                                        <strong>{{ $booking->room->name ?? 'Room' }}</strong>
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div>
                                        @if($booking->status == 'approved')
                                            <span class="badge-silih badge-silih-success">Disetujui</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="badge-silih badge-silih-warning">Menunggu</span>
                                        @elseif($booking->status == 'rejected')
                                            <span class="badge-silih badge-silih-danger">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state py-4">
                            <p class="text-muted">Belum ada pemesanan ruangan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="dashboard-column">
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">Peminjaman Saya</h3>
                    <a href="{{ route('item_borrowings.create') }}" class="btn btn-sm btn-silih-info">Pinjam Item</a>
                </div>
                <div class="card-body-silih p-0">
                    @if(isset($my_borrowings) && $my_borrowings->count() > 0)
                        <div class="list-group">
                            @foreach($my_borrowings as $borrowing)
                            <div class="list-group-item">
                                <div class="d-flex justify-between align-center">
                                    <div>
                                        <strong>{{ $borrowing->item->name ?? 'Item' }}</strong>
                                        <br><small class="text-muted">Jumlah: {{ $borrowing->quantity }} | Due: {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</small>
                                    </div>
                                    <div>
                                        @if($borrowing->status == 'borrowed')
                                            <span class="badge-silih badge-silih-primary">Dipinjam</span>
                                        @elseif($borrowing->status == 'pending')
                                            <span class="badge-silih badge-silih-warning">Menunggu</span>
                                        @elseif($borrowing->status == 'completed')
                                            <span class="badge-silih badge-silih-success">Dikembalikan</span>
                                        @elseif($borrowing->status == 'rejected')
                                            <span class="badge-silih badge-silih-danger">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state py-4">
                            <p class="text-muted">Belum ada peminjaman barang.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Available Items & Rooms -->
    <div class="dashboard-grid">
        <div class="dashboard-column">
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">Items Tersedia</h3>
                </div>
                <div class="card-body-silih p-0">
                    @if(isset($available_items) && $available_items->count() > 0)
                        <div class="list-group">
                            @foreach($available_items as $item)
                            <div class="list-group-item">
                                <strong>{{ $item->name }}</strong>
                                <span class="float-end">{{ $item->quantity }} unit</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-3 text-center text-muted">Tidak ada item tersedia</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="dashboard-column">
            <div class="card-silih">
                <div class="card-header-silih">
                    <h3 class="card-title-silih">Rooms Tersedia</h3>
                </div>
                <div class="card-body-silih p-0">
                    @if(isset($available_rooms) && $available_rooms->count() > 0)
                        <div class="list-group">
                            @foreach($available_rooms as $room)
                            <div class="list-group-item">
                                <strong>{{ $room->name }}</strong>
                                <span class="float-end">{{ $room->capacity }} orang</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-3 text-center text-muted">Tidak ada room tersedia</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.dashboard-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.list-group {
    list-style: none;
    padding: 0;
    margin: 0;
}

.list-group-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.list-group-item:last-child {
    border-bottom: none;
}

.list-group-item:hover {
    background-color: var(--gray-50);
}

.approval-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.approval-item {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.approval-item:last-child {
    border-bottom: none;
}

.approval-item:hover {
    background-color: var(--gray-50);
}

.approval-title {
    font-weight: 600;
    color: var(--gray-900);
}

.approval-meta {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin-top: 0.25rem;
}

.approval-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-action-success {
    background-color: var(--success-color);
    color: white;
    border: none;
    border-radius: var(--radius);
    padding: 0.5rem;
    cursor: pointer;
    transition: background-color var(--transition-fast);
}

.btn-action-success:hover {
    background-color: #16a34a;
}

.p-0 {
    padding: 0 !important;
}

.py-4 {
    padding-top: 2rem !important;
    padding-bottom: 2rem !important;
}

.justify-between {
    justify-content: space-between;
}

.align-center {
    align-items: center;
}
</style>
@endsection

