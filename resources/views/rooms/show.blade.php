@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Room Details</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p>{{ $room->id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p>{{ $room->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p>{{ $room->description }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Capacity:</label>
                        <p>{{ $room->capacity }} people</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <span class="badge bg-{{ $room->status == 'available' ? 'success' : 'danger' }}">
                            {{ $room->status }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p>{{ $room->created_at }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Updated At:</label>
                        <p>{{ $room->updated_at }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Back</a>
                        <div>
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

