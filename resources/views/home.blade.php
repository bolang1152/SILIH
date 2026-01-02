@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Dashboard</h1>
            <p class="text-muted">Welcome back, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Items Stats -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Items</h5>
                    <p class="card-text display-4">{{ $stats['total_items'] }}</p>
                    <p class="card-text"><small>{{ $stats['available_items'] }} available</small></p>
                </div>
            </div>
        </div>

        <!-- Rooms Stats -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Rooms</h5>
                    <p class="card-text display-4">{{ $stats['total_rooms'] }}</p>
                    <p class="card-text"><small>{{ $stats['available_rooms'] }} available</small></p>
                </div>
            </div>
        </div>

        <!-- Bookings Stats -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Room Bookings</h5>
                    <p class="card-text display-4">{{ $stats['total_bookings'] }}</p>
                    <p class="card-text"><small>{{ $stats['pending_bookings'] }} pending</small></p>
                </div>
            </div>
        </div>

        <!-- Borrowings Stats -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Item Borrowings</h5>
                    <p class="card-text display-4">{{ $stats['total_borrowings'] }}</p>
                    <p class="card-text"><small>{{ $stats['pending_borrowings'] }} pending</small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <a href="{{ route('items.index') }}" class="btn btn-primary w-100">Manage Items</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('rooms.index') }}" class="btn btn-success w-100">Manage Rooms</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('room_bookings.index') }}" class="btn btn-warning w-100">Room Bookings</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('item_borrowings.index') }}" class="btn btn-info w-100">Item Borrowings</a>
        </div>
    </div>

    <!-- Recent Data -->
    <div class="row">
        <!-- Recent Items -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Items</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status == 'available' ? 'success' : 'warning' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No items yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Rooms -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Rooms</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_rooms as $room)
                                <tr>
                                    <td>{{ $room->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $room->status == 'available' ? 'success' : 'danger' }}">
                                            {{ $room->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No rooms yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Room Bookings</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_bookings as $booking)
                                <tr>
                                    <td>Booking #{{ $booking->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No bookings yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Borrowings -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Item Borrowings</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_borrowings as $borrowing)
                                <tr>
                                    <td>Borrowing #{{ $borrowing->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $borrowing->status == 'completed' ? 'success' : ($borrowing->status == 'overdue' ? 'danger' : 'warning') }}">
                                            {{ $borrowing->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No borrowings yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

