@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h1>Item Borrowings</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('item_borrowings.create') }}" class="btn btn-primary">New Borrowing</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Item</th>
                        <th>Borrowed At</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowings as $borrowing)
                        <tr>
                            <td>{{ $borrowing->id }}</td>
                            <td>{{ $borrowing->user_id }}</td>
                            <td>{{ $borrowing->item_id }}</td>
                            <td>{{ $borrowing->borrowed_at }}</td>
                            <td>{{ $borrowing->due_date }}</td>
                            <td>
                                <span class="badge bg-{{ $borrowing->status == 'completed' ? 'success' : ($borrowing->status == 'overdue' ? 'danger' : 'warning') }}">
                                    {{ $borrowing->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('item_borrowings.show', $borrowing->id) }}" class="btn btn-sm btn-info">Show</a>
                                <a href="{{ route('item_borrowings.edit', $borrowing->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('item_borrowings.destroy', $borrowing->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

