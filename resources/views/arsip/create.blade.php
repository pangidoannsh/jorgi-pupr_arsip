@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-6">
            <form action="{{ route('arsip.store') }}" method="POST" class="d-flex flex-column card p-4" style="gap:12px"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="kode_klasifikasi">Kode Klasifikasi<span class="text-danger">*</span></label>
                    <select class="form-select @error('kode_klasifikasi') is-invalid @enderror" name="kode_klasifikasi"
                        id="kode_klasifikasi" required>
                        <option selected disabled>Pilih Kode Klasifikasi</option>
                        @foreach ($klasifikasi as $item)
                            <option value="{{ $item->kode_klasifikasi }}"
                                {{ old('kode_klasifikasi') == $item->kode_klasifikasi ? 'selected' : '' }}>
                                {{ $item->nama }} ({{ $item->kode_klasifikasi }})
                            </option>
                        @endforeach
                    </select>
                    @error('kode_klasifikasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_berkas">Nomor Berkas<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nomor_berkas') is-invalid @enderror" id="nomor_berkas"
                        placeholder="nomor_berkas" name="nomor_berkas" value="{{ old('nomor_berkas') }}" required>
                    @error('nomor_berkas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_arsip">Nomor Arsip<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nomor_arsip') is-invalid @enderror" id="nomor_arsip"
                        placeholder="nomor_arsip" name="nomor_arsip" value="{{ old('nomor_arsip') }}" required>
                    @error('nomor_arsip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="uraian_informasi">Uraian Informasi Arsip<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('uraian_informasi') is-invalid @enderror"
                        id="uraian_informasi" placeholder="uraian_informasi" name="uraian_informasi"
                        value="{{ old('uraian_informasi') }}" required>
                    @error('uraian_informasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <div class="fw-semibold">Kurun Waktu</div>
                    <hr class="my-1 divider">
                </div>
                <div class="row align-items-start">
                    <div class="col-6 form-group">
                        <label for="tanggal_mulai">Tanggal Mulai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                            id="tanggal_mulai" placeholder="tanggal_mulai" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai') }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label for="tanggal_selesai">Tanggal Selesai<span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                            id="tanggal_selesai" placeholder="tanggal_selesai" name="tanggal_selesai"
                            value="{{ old('tanggal_selesai') }}" required>
                        @error('tanggal_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah<span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                        placeholder="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tingkat_perkembangan">Tingkat Perkembangan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tingkat_perkembangan') is-invalid @enderror"
                        id="tingkat_perkembangan" placeholder="tingkat_perkembangan" name="tingkat_perkembangan"
                        value="{{ old('tingkat_perkembangan') }}" required>
                    @error('tingkat_perkembangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan_nomor_box">Keterangan Nomor Box<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('keterangan_nomor_box') is-invalid @enderror"
                        id="keterangan_nomor_box" placeholder="keterangan_nomor_box" name="keterangan_nomor_box"
                        value="{{ old('keterangan_nomor_box') }}" required>
                    @error('keterangan_nomor_box')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3">
                    <div class="fw-semibold">File<span class="text-danger">*</span></div>
                    <small>File dapat diupload melalui form atau memasukkan url file</small>
                </div>
                <div class="row align-items-start">
                    <div class="col-6 form-group">
                        <label for="file_upload">Upload File</label>
                        <input type="file" class="form-control @error('file_upload') is-invalid @enderror"
                            id="file_upload" name="file_upload">
                        @error('file_upload')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label for="url_file">Url File</label>
                        <input type="text" class="form-control @error('url_file') is-invalid @enderror"
                            id="url_file" placeholder="url_file" name="url_file" value="{{ old('url_file') }}">
                        @error('url_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary mt-4">Simpan</button>
            </form>

        </div>
    </div>
@endsection
