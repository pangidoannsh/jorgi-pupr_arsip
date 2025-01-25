@extends('layouts.main')
@push('title-prefix')
    <a href="{{ route('usulan.index') }}" class="btn btn-primary mb-3" style="width: max-content">Kembali</a>
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <form action="{{ route('suratCuti.store') }}" method="POST" class="d-flex flex-column card p-4" style="gap:12px"
                enctype="multipart/form-data">
                @csrf

                <!-- User yang mengajukan -->
                <div class="form-group">
                    <label for="user_id">Nama Pegawai yang Mengajukan<span class="text-danger">*</span></label>
                    <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" id="user_id"
                        required {{ Auth::user()->role == 'user' ? 'disabled' : '' }}>
                        @if (Auth::user()->role == 'admin')
                            <option selected disabled>Pilih Pegawai</option>
                        @endif
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- User yang membuat -->
                <input type="hidden" name="user_created" value="{{ Auth::id() }}">

                <!-- Jenis Cuti -->
                <div class="form-group">
                    <label for="jenis_cuti">Jenis Cuti<span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_cuti') is-invalid @enderror" name="jenis_cuti" id="jenis_cuti"
                        required>
                        <option selected disabled>Pilih Jenis Cuti</option>
                        <option value="tahunan" {{ old('jenis_cuti') == 'tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                        <option value="sakit" {{ old('jenis_cuti') == 'sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                        <option value="melahirkan" {{ old('jenis_cuti') == 'melahirkan' ? 'selected' : '' }}>Cuti
                            Melahirkan
                        </option>
                        <option value="alasan_penting" {{ old('jenis_cuti') == 'alasan_penting' ? 'selected' : '' }}>Cuti
                            Alasan Penting</option>
                    </select>
                    @error('jenis_cuti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lama Cuti -->
                <div class="form-group">
                    <label for="lama_cuti">Lama Cuti (Hari)<span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('lama_cuti') is-invalid @enderror" id="lama_cuti"
                        placeholder="Masukkan lama cuti" name="lama_cuti" value="{{ old('lama_cuti') }}" required>
                    @error('lama_cuti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai<span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alasan Cuti -->
                <div class="form-group">
                    <label for="alasan_cuti">Alasan Cuti<span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alasan_cuti') is-invalid @enderror" id="alasan_cuti" name="alasan_cuti"
                        rows="3" placeholder="Jelaskan alasan pengajuan cuti" required>{{ old('alasan_cuti') }}</textarea>
                    @error('alasan_cuti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Lampiran -->
                <div class="form-group">
                    <label for="lampiran_upload">Lampiran</label>
                    <small class="d-block mb-2">File pendukung dapat berupa surat keterangan dokter, dsb.</small>
                    <input type="file" class="form-control @error('lampiran_upload') is-invalid @enderror"
                        id="lampiran_upload" name="lampiran_upload">
                    @error('lampiran_upload')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tembusan -->
                <div class="form-group">
                    <div class="mt-2">
                        <div class="fw-semibold">Tembusan</div>
                        <hr class="my-1 divider">
                    </div>

                    <div id="tembusan-wrapper">
                        <div class="input-group mb-2">
                            <select class="form-select tembusan-select" name="tembusan[]">
                                <option selected disabled>Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-danger btn-remove d-none">Hapus</button>
                        </div>
                    </div>
                    <button type="button" id="btn-add-tembusan" class="btn btn-outline-secondary">
                        <i class="bi bi-plus-lg"></i>
                        <span class="fw-semibold">Tembusan</span>
                    </button>
                </div>

                <button class="btn btn-primary mt-4">Ajukan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#btn-add-tembusan').on('click', function() {
            const inputGroup = `
            <div class="input-group mb-2">
                <select class="form-select tembusan-select" name="tembusan[]">
                    <option selected disabled>Pilih User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-danger btn-remove">Hapus</button>
            </div>
        `;

            $('#tembusan-wrapper').append(inputGroup);
        });

        $('#tembusan-wrapper').on('click', '.btn-remove', function() {
            $(this).closest('.input-group').remove();
        });

        $(".tembusan-select").on("change", function() {
            $(".btn-remove").removeClass("d-none");
        })
    </script>
@endpush
