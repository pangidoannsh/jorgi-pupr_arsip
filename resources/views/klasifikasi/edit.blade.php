@extends('layouts.main')

@push('title-prefix')
    <a href="{{ route('klasifikasi.index') }}" class="btn btn-primary mb-3" style="width: max-content">Kembali</a>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="{{ route('klasifikasi.update', $model->id) }}" method="POST" class="d-flex flex-column card p-4"
                style="gap:12px">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="kode_klasifikasi">Kode Klasifikasi<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('kode_klasifikasi') is-invalid @enderror"
                        id="kode_klasifikasi" placeholder="kode_klasifikasi" name="kode_klasifikasi"
                        value="{{ old('kode_klasifikasi', $model->kode_klasifikasi) }}" required>
                    @error('kode_klasifikasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        placeholder="nama" name="nama" value="{{ old('nama', $model->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary mt-4">Perbarui</button>
            </form>

        </div>
    </div>
@endsection
