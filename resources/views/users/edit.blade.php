@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password (biarkan kosong jika tetap ingin pakai password yang sekarang)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <select name="branch_id" class="form-control">
                <option value="">-- Pilih Lokasi --</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}"
                        @if($user->branch_id == $branch->id) selected @endif>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @if($user->roles->first()?->name == $role) selected @endif>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
