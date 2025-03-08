@extends('layouts.main')

@push('title-prefix')
    <a href="{{ route('unit.index') }}" class="btn btn-primary mb-3" style="width: max-content">Kembali</a>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="{{ route('unit.store') }}" method="POST" class="d-flex flex-column card p-4" style="gap:12px">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        placeholder="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary mt-4">Simpan</button>
            </form>

        </div>
    </div>
@endsection
