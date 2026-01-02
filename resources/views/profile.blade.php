@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Profile</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p>{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p>{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone Number:</label>
                        <p>{{ $user->phone_number ?? 'Not set' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address:</label>
                        <p>{{ $user->address ?? 'Not set' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Verified At:</label>
                        <p>{{ $user->email_verified_at ?? 'Not verified' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p>{{ $user->created_at }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

