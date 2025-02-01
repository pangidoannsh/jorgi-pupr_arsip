<?php

namespace App\Http\Controllers;

use App\Models\SuratCuti;
use App\Models\TembusanSurat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SuratCutiController extends Controller
{
    protected $upload_path = 'uploads/lampiran_surat_cuti/';

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select("id", "name")->get();
        return view('usulan.suratCuti.create', ["title" => "Usulan Surat Cuti", "isTitleCenter" => true, "users" => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti' => 'required|string',
            'lama_cuti' => 'required|integer|min:1',
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
        Alert::success('Berhasil', 'Surat cuti telah ditolak.');
        return redirect()->back();
    }
    public function setujuiAdmin($id)
    {
        $suratCuti = SuratCuti::findOrFail($id);
        $suratCuti->status = "disetujui_admin";
        $suratCuti->update();
        Alert::success('Berhasil', 'Surat cuti berhasil disetujui oleh admin.');
        return redirect()->back();
    }
    public function setujui($id)
    {
        $suratCuti = SuratCuti::findOrFail($id);
        $suratCuti->status = "disetujui";
        $suratCuti->update();
        Alert::success('Berhasil', 'Surat cuti telah disetujui.');
        return redirect()->back();
    }

    public function print($id)
    {
        $suratCuti = SuratCuti::findOrFail($id);
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true])->setPaper('A4');
        $kepalaDinas = User::where("role", "kepala_dinas")->select("name", "nip")->first();
        $pdf->loadView('pdf.suratCuti', ["model" => $suratCuti, "perihal" => "Surat Permohonan Cuti", "kepalaDinas" => $kepalaDinas]);
        return $pdf->stream('Surat Cuti.pdf');
    }
}
