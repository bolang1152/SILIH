@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Item Details</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p>{{ $item->id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p>{{ $item->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p>{{ $item->description }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Quantity:</label>
                        <p>{{ $item->quantity }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <span class="badge bg-{{ $item->status == 'available' ? 'success' : 'warning' }}">
                            {{ $item->status }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p>{{ $item->created_at }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Updated At:</label>
                        <p>{{ $item->updated_at }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                        <div>
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

