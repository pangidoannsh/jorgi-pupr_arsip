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
                <a href="" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Arsip Dokmen
                </a>
            </div>
            <!-- Table with hoverable rows -->
            {{-- <table class="table table-hover table-stripped" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Pembuat</th>
                        <th scope="col">Tanggal Dibuat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $item)
                        <tr data-link="{{ $item->link }}">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->category?->name ?? '-' }}</td>
                            <td><a href="{{ $item->link }}" target="_blank">{{ $item->name }}</a></td>
                            <td>{{ $item->user?->name ?? '-' }}</td>
                            <td>{{ Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('report.edit', $item) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('report.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            style="border-radius: 0 .25rem .25rem 0">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
            <!-- End Table with hoverable rows -->

        </div>
    </div>
@endsection
@push('scripts')
    <script></script>
@endpush
