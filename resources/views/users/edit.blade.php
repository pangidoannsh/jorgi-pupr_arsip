@extends('layouts.main')
@php
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
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="{{ route('users.store') }}" method="POST" class="d-flex flex-column card p-4" style="gap:12px"
                enctype="multipart/form-data">
                @csrf
                {{-- NIP --}}
                <div class="form-group">
                    <label for="nip">NIP<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                        placeholder="nip" name="nip" value="{{ old('nip', $model->nip) }}" required>
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- NAMA --}}
                <div class="form-group">
                    <label for="name">Nama<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="name" name="name" value="{{ old('name', $model->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- UNIT --}}
                <div class="form-group">
                    <label for="unit_id">Unit<span class="text-danger">*</span></label>
                    <select class="form-select @error('unit_id') is-invalid @enderror" name="unit_id" id="unit_id"
                        required>
                        <option selected disabled>-Pilih Unit-</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}"
                                {{ old('unit_id', $model->unit_id) == $unit->id ? 'selected' : '' }}>
                                {{ $unit->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- JABATAN --}}
                <div class="form-group">
                    <label for="jabatan">Jabatan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                        placeholder="jabatan" name="jabatan" value="{{ old('jabatan', $model->jabatan) }}" required>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ROLE --}}
                <div class="form-group">
                    <label for="role">Role<span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" name="role" id="role" required>
                        <option selected disabled>Pilih Role</option>
                        @foreach ($roleOptions as $role)
                            <option value="{{ $role['value'] }}"
                                {{ old('role', $model->role) == $role['value'] ? 'selected' : '' }}>
                                {{ $role['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label for="password_input">Password</label>
                    <input type="password" class="form-control @error('password_input') is-invalid @enderror"
                        id="password_input" placeholder="password_input" name="password_input" value="">
                    @error('password_input')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TTD UPLOAD --}}
                <div class="col-6 form-group">
                    <div class="d-flex align-items-center">
                        <label for="ttd_upload">Upload TTD</label>
                        @if ($model->ttd)
                            <a href="{{ asset($model->ttd) }}" class="btn btn-primary btn-sm" target="_blank">
                                Lihat TTD Sekarang
                            </a>
                        @endif
                    </div>
                    <input type="file" class="form-control @error('ttd_upload') is-invalid @enderror" id="ttd_upload"
                        name="ttd_upload">
                    @error('ttd_upload')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary mt-4">Simpan</button>
            </form>

        </div>
    </div>
@endsection
