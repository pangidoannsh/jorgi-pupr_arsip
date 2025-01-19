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
                <a href="{{ route('arsip.create') }}" class="btn btn-primary" style="width: max-content">
                    <i class="bi bi-plus"></i> Arsip Dokmen
                </a>
            </div>
            <!-- Table with hoverable rows -->
            <table class="table table-hover table-stripped" id="dataTable">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Klasifikasi</th>
                        <th scope="col">Nomor Berkas</th>
                        <th scope="col">Nomor Arsip</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Tingkat Perkembangan</th>
                        <th scope="col">Kurun Waktu</th>
                        <th scope="col">Pembuat</th>
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
                    url: "{{ route('arsip.data') }}",
                    data: function(data) {
                        data.klasifikasi = $("#filterKlasifikasi").val()
                        data.user = $("#filterUser").val()
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'klasifikasi',
                        name: 'Klasifikasi',
                        orderable: false,

                    },
                    {
                        data: 'nomor_berkas',
                        name: 'Nomor Berkas',
                        orderable: false,
                    },
                    {
                        data: 'nomor_arsip',
                        name: 'Nomor Arsip',
                        orderable: false,
                    },
                    {
                        data: 'jumlah',
                        name: 'Jumlah',
                        orderable: false,
                    },
                    {
                        data: 'tingkat_perkembangan',
                        name: 'Tingkat Perkembangan',
                        orderable: false,
                    },

                    {
                        data: 'kurun_waktu',
                        name: 'Kurun Waktu',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user',
                        orderable: false,

                    },
                    {
                        data: 'action',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
            })
            $("#filterKlasifikasi").on("change", function() {
                table.ajax.reload();
            })
            $("#filterUser").on("change", function() {
                table.ajax.reload();
            })
        })
    </script>
    <script>
        $(document).on("submit", ".formDelete", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Arsip ini akan dihapus secara permanen!",
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
