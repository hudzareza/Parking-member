@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Member</h1>
    <a href="{{ route('members.create') }}" class="btn btn-primary mb-3">Tambah Member</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Cabang</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $member->user->name }}</td>
                <td>{{ $member->user->email }}</td>
                <td>{{ $member->branch->name }}</td>
                <td>{{ $member->phone }}</td>
                <td>
                    <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus member ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $members->links() }}
</div>
@endsection
