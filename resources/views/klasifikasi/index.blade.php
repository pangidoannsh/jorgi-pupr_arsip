@php
    use Carbon\Carbon;
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
                <a href="{{ route('klasifikasi.create') }}" class="btn btn-primary" style="width: max-content">
                    <i class="bi bi-plus"></i> Klasifikasi
                </a>
            </div>
            <!-- Table with hoverable rows -->
            <table class="table table-hover table-stripped" id="dataTable">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama</th>
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
                    url: "{{ route('klasifikasi.data') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_klasifikasi',
                        name: 'Kode',
                        orderable: false,

                    },
                    {
                        data: 'nama',
                        name: 'Nama',
                        orderable: false,

                    },
                    {
                        data: 'action',
                        name: 'Aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                    targets: 0,
                    className: "text-center",
                    width: "120px"
                }]
            })
        })
    </script>
    <script>
        $(document).on("submit", ".formDelete", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Klasifikasi ini akan dihapus secara permanen!",
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
