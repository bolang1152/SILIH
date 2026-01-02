@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Item Borrowing</div>

                <div class="card-body">
                    <form action="{{ route('item_borrowings.update', $borrowing->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="number" class="form-control @error('user_id') is-invalid @enderror" 
                                   id="user_id" name="user_id" value="{{ old('user_id', $borrowing->user_id) }}" required>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item ID</label>
                            <input type="number" class="form-control @error('item_id') is-invalid @enderror" 
                                   id="item_id" name="item_id" value="{{ old('item_id', $borrowing->item_id) }}" required>
                            @error('item_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="borrowed_at" class="form-label">Borrowed At</label>
                            <input type="datetime-local" class="form-control @error('borrowed_at') is-invalid @enderror" 
                                   id="borrowed_at" name="borrowed_at" value="{{ old('borrowed_at', $borrowing->borrowed_at) }}" required>
                            @error('borrowed_at')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" 
                                   id="due_date" name="due_date" value="{{ old('due_date', $borrowing->due_date) }}" required>
                            @error('due_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="pending" {{ $borrowing->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $borrowing->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="overdue" {{ $borrowing->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('item_borrowings.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update Borrowing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

