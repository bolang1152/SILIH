@extends('layouts.app')

@section('content')
<div class="page-header-silih">
    <div class="page-header-content">
        <div class="page-title-wrapper">
            <div class="page-title-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="page-title">
                <h1>Room Bookings</h1>
                <p class="page-subtitle">Kelola pemesanan ruangan</p>
            </div>
        </div>
        <div class="page-actions">
            <a href="{{ route('room_bookings.create') }}" class="btn-silih btn-silih-warning">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Booking Baru
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
            <div class="stat-icon stat-icon-warning">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $bookings->count() }}</span>
                <span class="stat-label">Total Bookings</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-info">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $bookings->where('status', 'pending')->count() }}</span>
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
                <span class="stat-value">{{ $bookings->where('status', 'approved')->count() }}</span>
                <span class="stat-label">Disetujui</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-danger">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $bookings->where('status', 'rejected')->count() }}</span>
                <span class="stat-label">Ditolak</span>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-silih">
        <div class="card-header-silih">
            <h3 class="card-title-silih">Daftar Room Bookings</h3>
            <div class="card-actions">
                <div class="search-box-silih">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchBookings" placeholder="Cari bookings..." class="search-input">
                </div>
            </div>
        </div>
        <div class="card-body-silih">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table-silih" id="bookingsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pengguna</th>
                                <th>Room</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <span class="item-id">#{{ $booking->id }}</span>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar-sm">{{ substr($booking->user->name ?? 'U', 0, 1) }}</div>
                                            <span>{{ $booking->user->name ?? 'User #' . $booking->user_id }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item-name">
                                            <div class="item-icon item-icon-room">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            {{ $booking->room->name ?? 'Room #' . $booking->room_id }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td>
                                        <span class="date-text">{{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td>
                                        @if($booking->status == 'approved')
                                            <span class="status-badge status-available">Disetujui</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="status-badge status-warning">Menunggu</span>
                                        @elseif($booking->status == 'rejected')
                                            <span class="status-badge status-danger">Ditolak</span>
                                        @else
                                            <span class="status-badge">{{ $booking->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('room_bookings.show', $booking->id) }}" class="btn-action btn-action-info" title="Lihat">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('room_bookings.edit', $booking->id) }}" class="btn-action btn-action-warning" title="Edit">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('room_bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3>Belum ada bookings</h3>
                    <p>Mulai dengan membuat booking ruangan pertama.</p>
                    <a href="{{ route('room_bookings.create') }}" class="btn-silih btn-silih-warning">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Booking Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('searchBookings').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const table = document.getElementById('bookingsTable');
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

