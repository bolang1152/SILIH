@extends('layouts.app')

@section('content')
<div class="page-header-silih">
    <div class="page-header-content">
        <div class="page-title-wrapper">
            <div class="page-title-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="page-title">
                <h1>Rooms</h1>
                <p class="page-subtitle">Kelola ruangan untuk peminjaman</p>
            </div>
        </div>
        <div class="page-actions">
            <a href="{{ route('rooms.create') }}" class="btn-silih btn-silih-success">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Room
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
            <div class="stat-icon stat-icon-success">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $rooms->count() }}</span>
                <span class="stat-label">Total Rooms</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-primary">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $rooms->sum('capacity') }}</span>
                <span class="stat-label">Total Kapasitas</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-success">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $rooms->where('status', 'available')->count() }}</span>
                <span class="stat-label">Tersedia</span>
            </div>
        </div>
        <div class="stat-card-silih">
            <div class="stat-icon stat-icon-danger">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $rooms->where('status', 'maintenance')->count() }}</span>
                <span class="stat-label">Maintenance</span>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-silih">
        <div class="card-header-silih">
            <h3 class="card-title-silih">Daftar Rooms</h3>
            <div class="card-actions">
                <div class="search-box-silih">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchRooms" placeholder="Cari rooms..." class="search-input">
                </div>
            </div>
        </div>
        <div class="card-body-silih">
            @if($rooms->count() > 0)
                <div class="table-responsive">
                    <table class="table-silih" id="roomsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Room</th>
                                <th>Deskripsi</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td>
                                        <span class="item-id">#{{ $room->id }}</span>
                                    </td>
                                    <td>
                                        <div class="item-name">
                                            <div class="item-icon item-icon-room">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            {{ $room->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="item-description">{{ Str::limit($room->description, 40) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-silih badge-silih-outline">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $room->capacity }} orang
                                        </span>
                                    </td>
                                    <td>
                                        @if($room->status == 'available')
                                            <span class="status-badge status-available">Tersedia</span>
                                        @elseif($room->status == 'maintenance')
                                            <span class="status-badge status-warning">Maintenance</span>
                                        @else
                                            <span class="status-badge status-danger">{{ $room->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('rooms.show', $room->id) }}" class="btn-action btn-action-info" title="Lihat">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn-action btn-action-warning" title="Edit">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus room ini?')">
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
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3>Belum ada rooms</h3>
                    <p>Mulai dengan menambahkan room pertama untuk inventaris Anda.</p>
                    <a href="{{ route('rooms.create') }}" class="btn-silih btn-silih-success">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Room Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Simple search functionality
    document.getElementById('searchRooms').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const table = document.getElementById('roomsTable');
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

