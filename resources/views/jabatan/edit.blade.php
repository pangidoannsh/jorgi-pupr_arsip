@extends('layouts.main')

@push('title-prefix')
    <a href="{{ route('unit.index') }}" class="btn btn-primary mb-3" style="width: max-content">Kembali</a>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="{{ route('jabatan.update', $model->id) }}" method="POST" class="d-flex flex-column card p-4"
                style="gap:12px">
                @csrf
                @method('PUT')
                {{-- Nama --}}
                <div class="form-group">
                    <label for="nama">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        placeholder="nama" name="nama" value="{{ old('nama', $model->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Diajukan Kepada --}}
                <div class="form-group">
                    <label for="user_id">Diajukan Kepada<span class="text-danger">*</span></label>
                    <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_id"
                        required>
                        <option selected disabled>Pilih Pegawai</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id', $model->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary mt-4">Perbarui</button>
            </form>

        </div>
    </div>
@endsection
