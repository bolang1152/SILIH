@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Room Booking Details</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p>{{ $booking->id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">User ID:</label>
                        <p>{{ $booking->user_id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Room ID:</label>
                        <p>{{ $booking->room_id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Start Time:</label>
                        <p>{{ $booking->start_time }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">End Time:</label>
                        <p>{{ $booking->end_time }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'warning') }}">
                            {{ $booking->status }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p>{{ $booking->created_at }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Updated At:</label>
                        <p>{{ $booking->updated_at }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('room_bookings.index') }}" class="btn btn-secondary">Back</a>
                        <div>
                            <a href="{{ route('room_bookings.edit', $booking->id) }}" class="btn btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

