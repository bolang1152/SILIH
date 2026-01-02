# TODO: Fix Intelephense Undefined Method Warnings in Controllers

## Issue
Intelephense reports "Undefined method" warnings for:
- `auth()->user()` - `user` method
- `auth()->id()` - `id` method  
- `$model->user` - `user` property
- `$model->user->id` - `id` property

## Root Cause
Intelephense doesn't recognize Laravel's auth() helper dynamic return types and Eloquent relationship dynamic properties.

## Solution
Add docblock type hints to help Intelephense understand the types.

## Tasks
- [x] Read and analyze ItemBorrowingController.php
- [x] Read User.php and ItemBorrowing.php models
- [x] Fix ItemBorrowingController.php
- [x] Read and analyze RoomBookingController.php
- [x] Fix RoomBookingController.php
- [x] Verify PHP syntax for both files

## Files Fixed

### ItemBorrowingController.php
- Added `use Illuminate\Support\Facades\Auth;`
- Added `@var \App\Models\User` docblocks in methods: index, show, update, destroy, approve, reject, returnItem
- Replaced `auth()->user()` with typed `Auth::user()`
- Replaced `auth()->id()` with `Auth::id()`

### RoomBookingController.php
- Added `use Illuminate\Support\Facades\Auth;`
- Added `@var \App\Models\User` docblocks in methods: index, show, update, destroy, approve, reject
- Replaced `auth()->user()` with typed `Auth::user()`
- Replaced `auth()->id()` with `Auth::id()`

## Verification
- PHP syntax check: No errors in both files

