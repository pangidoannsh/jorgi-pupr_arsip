@php
    use Carbon\Carbon;
    $roleOptions = [
        [
            'label' => 'Admin',
            'value' => 'admin',
        ],
        [
            'label' => 'User',
            'value' => 'user',
        ],
        [
            'label' => 'Kepala Dinas',
            'value' => 'kepala_dinas',
        ],
    ];
@endphp
@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mt-3 mb-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <a href="{{ route('users.create') }}" class="btn btn-primary" style="width: max-content">
                    <i class="bi bi-plus"></i> User
                </a>
            </div>
            <div class="d-flex" style="gap: 12px">
                <label for="unit" class="form-label">
                    Unit
                    <select name="unit" id="filterUnit" class="form-control">
                        <option value="">Semua Unit</option>
                        @foreach ($units as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="role" class="form-label">
                    Role
                    <select name="role" id="filterRole" class="form-control">
                        <option value="">Semua Role</option>
                        @foreach ($roleOptions as $role)
                            <option value="{{ $role['value'] }}">{{ $role['label'] }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <!-- Table with hoverable rows -->
            <table class="table table-hover table-stripped" id="dataTable">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Role</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
            <!-- End Table with hoverable rows -->

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $("#dataTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.data') }}",
                    data: function(data) {
                        data.unit = $("#filterUnit").val()
                        data.role = $("#filterRole").val()
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                    },
                    {
                        data: 'nip',
                        name: 'NIP',
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'Nama',
                        orderable: false,
                    },
                    {
                        data: 'unit',
                        name: 'Unit',
                        orderable: false,
                    },
                    {
                        data: 'jabatan',
                        name: 'Jabatan',
                        orderable: false,
                    },
                    {
                        data: 'role',
                        name: 'Role',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'aksi',
                        orderable: false,
                    },
                ],
                columnDefs: [{
                    targets: 0,
                    className: "text-center",
                }]
            })
            $("#filterUnit").on("change", function() {
                table.ajax.reload();
            })
            $("#filterRole").on("change", function() {
                table.ajax.reload();
            })
        })
    </script>
    <script>
        $(document).on("submit", ".formDelete", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "User ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.currentTarget.submit()
                }
            });
        })
    </script>
@endpush
