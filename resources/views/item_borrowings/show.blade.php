@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Item Borrowing Details</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p>{{ $borrowing->id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">User ID:</label>
                        <p>{{ $borrowing->user_id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Item ID:</label>
                        <p>{{ $borrowing->item_id }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Borrowed At:</label>
                        <p>{{ $borrowing->borrowed_at }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Due Date:</label>
                        <p>{{ $borrowing->due_date }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <span class="badge bg-{{ $borrowing->status == 'completed' ? 'success' : ($borrowing->status == 'overdue' ? 'danger' : 'warning') }}">
                            {{ $borrowing->status }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p>{{ $borrowing->created_at }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Updated At:</label>
                        <p>{{ $borrowing->updated_at }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('item_borrowings.index') }}" class="btn btn-secondary">Back</a>
                        <div>
                            <a href="{{ route('item_borrowings.edit', $borrowing->id) }}" class="btn btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

