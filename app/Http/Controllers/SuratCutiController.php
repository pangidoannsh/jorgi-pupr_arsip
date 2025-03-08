<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Jabatan;
use App\Models\Notification;
use App\Models\SuratCuti;
use App\Models\TembusanSurat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SuratCutiController extends Controller
{
    protected $upload_path = 'uploads/lampiran_surat_cuti/';

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select("id", "name")->get();
        $jabatans = Jabatan::with("user")->get();
        return view('usulan.suratCuti.create', ["title" => "Usulan Surat Cuti", "isTitleCenter" => true, "jabatans" => $jabatans, "users" => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'diajukan_kepada' => 'required',
            'jenis_cuti' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan_cuti' => 'required|string|max:500',
            'tembusan' => 'nullable|array',
            'tembusan.*' => 'exists:users,id',
        ], [
            'lampiran_upload.required_without' => 'Lampiran harus diunggah jika URL file tidak diisi.',
            'url_file.required_without' => 'URL file harus diisi jika lampiran tidak diunggah.',
        ]);
        // Simpan file lampiran jika ada
        if ($request->hasFile('lampiran_upload')) {
            $request->merge(['lampiran' => FileController::store($request->file('lampiran_upload'), $this->upload_path)]);
        }

        // Simpan data surat cuti
        $suratCuti = SuratCuti::create($request->all());

        // Simpan tembusan jika ada
        if ($request->filled('tembusan')) {
            foreach ($request->tembusan as $userId) {
                TembusanSurat::create([
                    'jenis_surat' => "surat_cuti",
                    'surat_id' => $suratCuti->id,
                    'user_tembusan_id' => $userId,
                ]);
            }
        }
        $pengaju = User::find($suratCuti->user_id);

        Notification::create([
            'user_id' => $suratCuti->user_id,
            'title' => "Pengajuan Surat Cuti",
            "link" => "usulan/surat-cuti/" . $suratCuti->id,
            'text' => "Surat cuti oleh {$pengaju?->name} telah diajukan.",
        ]);

        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "melakukan pembuatan surat permohonan cuti",
            "type" => "primary"
        ]);

        $admins = User::select("id")->where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => "Pengajuan Surat Cuti",
                "link" => "usulan/surat-cuti/" . $suratCuti->id,
                'text' => "Surat cuti oleh {$pengaju?->name} telah diajukan dan membutuhkan persetujuan admin",
            ]);
        }

        // Redirect dengan pesan sukses
        Alert::success('Berhasil', 'Surat cuti berhasil diajukan.');
        return redirect()->route('usulan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = SuratCuti::findOrFail($id);
        return view('usulan.suratCuti.show', ["title" => $model->nama, "isTitleCenter" => true, "model" => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratCuti $suratCuti)
    {
        return view('usulan.suratCuti.edit', ["title" => "Edit Surat Cuti", "isTitleCenter" => true, "model" => $suratCuti]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratCuti $suratCuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratCuti $suratCuti)
    {
        //
    }

    public function tolak($id, Request $request)
    {
        $suratCuti = SuratCuti::findOrFail($id);
        $suratCuti->status = "ditolak";
        $suratCuti->alasan_ditolak = $request->alasan_ditolak;
        $suratCuti->update();
        Notification::create([
            'user_id' => $suratCuti->user_id,
            'title' => "Pengajuan Surat Cuti",
            "link" => "usulan/surat-cuti/" . $suratCuti->id,
            'text' => "Pengajuan Cuti Ditolak"
        ]);
        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "pengajuan cuti ditolak oleh " . Auth::user()->jabatan,
            "type" => "danger"
        ]);
        Alert::success('Berhasil', 'Surat cuti telah ditolak.');
        return redirect()->back();
    }
    public function setujuiAdmin($id)
    {
        $suratCuti = SuratCuti::findOrFail($id);
        $suratCuti->status = "disetujui_admin";
        $suratCuti->update();

        Notification::create([
            'user_id' => $suratCuti->user_id,
            'title' => "Pengajuan Surat Cuti",
            "link" => "usulan/surat-cuti/" . $suratCuti->id,
            'text' => "Pengajuan Cuti Disetujui oleh Admin dan menunggu persetujuan Kepala Dinas"
        ]);
        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "pengajuan cuti disetujui oleh Admin",
            "type" => "success"
        ]);
        $kepalaDinas = User::select("id")->where('role', 'kepala_dinas')->first();
        $pengaju = $suratCuti->pengaju;

        if ($kepalaDinas) {
            Notification::create([
                'user_id' => $kepalaDinas->id,
                'title' => "Pengajuan Surat Cuti",
                "link" => "usulan/surat-cuti/" . $suratCuti->id,
                'text' => "Permohonan Cuti oleh {$pengaju?->name} telah disetujui oleh admin dan membuatuhkan persetujuan Kepala Dinas",
            ]);
        }
        Alert::success('Berhasil', 'Surat cuti berhasil disetujui oleh admin.');
        return redirect()->back();
    }
    public function setujui($id)
    {
        $suratCuti = SuratCuti::findOrFail($id);
        $suratCuti->status = "disetujui";
        $suratCuti->approved_at = now();
        $suratCuti->update();
        Notification::create([
            'user_id' => $suratCuti->user_id,
            'title' => "Pengajuan Surat Cuti",
            "link" => "usulan/surat-cuti/" . $suratCuti->id,
            'text' => "Pengajuan Cuti telah disetujui Kepala Dinas"
        ]);
        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "pengajuan cuti disetujui oleh Kepala dinas",
            "type" => "success"
        ]);
        Alert::success('Berhasil', 'Surat cuti telah disetujui.');
        return redirect()->back();
    }

    public function print($id)
    {
        $suratCuti = SuratCuti::findOrFail($id);
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true])->setPaper('A4');
        $encryptedId = base64_encode($suratCuti->id);
        $kepalaDinas = User::where('role', 'kepala_dinas')->first();
        $qrCode = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate(url("/surat-cuti/{$encryptedId}")));
        $pdf->loadView('pdf.suratCuti', ["model" => $suratCuti, "perihal" => "Surat Permohonan Cuti", "qrCode" => $qrCode]);
        return $pdf->stream('Surat Cuti.pdf');
    }
}
