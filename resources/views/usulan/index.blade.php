@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-body pt-3">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('usulan') ? 'active fw-bold' : '' }}" aria-current="page"
                        href="{{ route('usulan.riwayat') }}">Usulan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('riwayat-usulan') ? 'active fw-bold' : '' }}" aria-current="page"
                        href="{{ route('usulan.riwayat') }}">Riwayat</a>
                </li>
            </ul>
            <div class="mt-3 mb-2">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" id="dropdownUsulan" data-bs-toggle="dropdown"
                        aria-expanded="false" style="width: max-content">
                        <i class="bi bi-plus"></i> Usulan
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownUsulan">
                        <a class="dropdown-item" href="{{ route('suratCuti.create') }}">Surat Cuti</a>
                        <a class="dropdown-item" href="{{ route('suratPengantar.create') }}">Surat Pengantar</a>
                        <a class="dropdown-item" href="#">Lainnya</a>
                    </div>
                </div>
            </div>
            <!-- Table with hoverable rows -->
            <table class="table table-hover table-stripped" id="dataTable">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jenis Usulan</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Pengaju</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jenisUsulan }}</td>
                            @switch($item->jenisUsulan)
                                @case('Surat Cuti')
                                    <td>
                                        Pengajuan Cuti - {{ $item->jenis_cuti }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>Tanggal Mulai: {{ $item->tanggal_mulai }}</span>
                                            <span>Lama Cuti: {{ $item->lama_cuti }}</span>
                                            <span>Alasan: {{ $item->alasan_cuti }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->pengaju?->name }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('suratCuti.show', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                @case('Surat Pengantar')
                                    <td>
                                        Pengajuan Surat Pengantar
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>Keperluan: {{ $item->keperluan }}</span>
                                            <span>Lokasi Kegiatan: {{ $item->lokasi_kegiatan }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->pengaju?->name }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('suratPengantar.show', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                @break

                                @default
                                    undefined
                            @endswitch
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with hoverable rows -->

        </div>
    </div>
@endsection
@push('scripts')
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
