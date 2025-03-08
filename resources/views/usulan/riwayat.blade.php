@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-body pt-3">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('usulan') ? 'active fw-bold' : '' }}" aria-current="page"
                        href="{{ route('usulan.index') }}">Usulan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('riwayat-usulan') ? 'active fw-bold' : '' }}" aria-current="page"
                        href="{{ route('usulan.riwayat') }}">Riwayat</a>
                </li>
            </ul>
            <!-- Table with hoverable rows -->
            <table class="table table-hover table-stripped mt-4" id="dataTable">
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
