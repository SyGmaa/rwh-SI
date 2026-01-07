@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Pengguna</h4>
                    <div class="card-header-action">
                        <a href="{{ route('user-management.create') }}" class="btn btn-primary"><i
                                class="fas fa-plus"></i> Tambah Pengguna</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="badge badge-success">{{ $user->role }}</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('user-management.edit', $user->id) }}"
                                            class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                            title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('user-management.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-action" data-toggle="tooltip"
                                                title="Delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
