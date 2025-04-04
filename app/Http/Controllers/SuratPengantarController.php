<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Jabatan;
use App\Models\Notification;
use App\Models\SuratPengantar;
use App\Models\TembusanSurat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SuratPengantarController extends Controller
{
    protected $upload_path = 'uploads/lampiran_surat_pengantar/';

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select("id", "name")->get();
        $jabatans = Jabatan::with("user")->get();
        return view('usulan.suratPengantar.create', ["title" => "Usulan Pengantar", "isTitleCenter" => true, "jabatans" => $jabatans, "users" => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'diajukan_kepada' => 'required',
                'keperluan' => 'required|string|max:500',
                'tembusan' => 'nullable|array',
                'tembusan.*' => 'exists:users,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); // Menampilkan detail error
        }
        // Simpan file lampiran jika ada
        if ($request->hasFile('lampiran_upload')) {
            $request->merge(['lampiran' => FileController::store($request->file('lampiran_upload'), $this->upload_path)]);
        }

        // Simpan data surat pengantar
        $suratPengantar = SuratPengantar::create($request->all());

        // Simpan tembusan jika ada
        if ($request->filled('tembusan')) {
            foreach ($request->tembusan as $userId) {
                TembusanSurat::create([
                    'jenis_surat' => "surat_pengantar",
                    'surat_id' => $suratPengantar->id,
                    'user_tembusan_id' => $userId,
                ]);
            }
        }
        $pengaju = User::find($suratPengantar->user_id);

        Notification::create([
            'user_id' => $suratPengantar->user_id,
            'title' => "Pengajuan Surat Pengantar",
            "link" => "usulan/surat-pengantar/" . $suratPengantar->id,
            'text' => "Surat pengantar oleh {$pengaju?->name} telah diajukan.",
        ]);

        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "melakukan pembuatan surat pengantar",
            "type" => "primary"
        ]);

        $admins = User::select("id")->where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => "Pengajuan Surat Pengantar",
                "link" => "usulan/surat-pengantar/" . $suratPengantar->id,
                'text' => "Surat pengantar oleh {$pengaju?->name} telah diajukan dan membutuhkan persetujuan admin",
            ]);
        }

        // Redirect dengan pesan sukses
        Alert::success('Berhasil', 'Surat pengantar berhasil diajukan.');
        return redirect()->route('usulan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = SuratPengantar::findOrFail($id);
        return view('usulan.suratPengantar.show', ["title" => $model->nama, "isTitleCenter" => true, "model" => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function tolak($id, Request $request)
    {
        $model = SuratPengantar::findOrFail($id);
        $model->status = "ditolak";
        $model->alasan_ditolak = $request->alasan_ditolak;
        $model->update();
        Notification::create([
            'user_id' => $model->user_id,
            'title' => "Pengajuan Surat Pengantar",
            "link" => "usulan/surat-pengantar/" . $model->id,
            'text' => "Pengajuan Surat Pengantar Ditolak"
        ]);
        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "pengajuan surat pengantar ditolak oleh " . Auth::user()->jabatan,
            "type" => "danger"
        ]);
        Alert::success('Berhasil', 'Surat Pengantar telah ditolak.');
        return redirect()->back();
    }

    public function setujuiAdmin($id)
    {
        $suratPengantar = SuratPengantar::findOrFail($id);
        $suratPengantar->status = "disetujui_admin";
        $suratPengantar->update();

        $link = "usulan/surat-pengantar/" . $suratPengantar->id;

        Notification::create([
            'user_id' => $suratPengantar->user_id,
            'title' => "Pengajuan Surat Pengatar",
            "link" => $link,
            'text' => "Pengajuan Pengantar Disetujui oleh Admin dan menunggu persetujuan Kepala Dinas"
        ]);

        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "pengajuan surat pengantar disetujui oleh Admin",
            "type" => "success"
        ]);
        $kepalaDinas = User::select("id")->where('role', 'kepala_dinas')->first();
        $pengaju = $suratPengantar->pengaju;

        if ($kepalaDinas) {
            Notification::create([
                'user_id' => $kepalaDinas->id,
                'title' => "Pengajuan Surat Pengatar",
                "link" => $link,
                'text' => "Pengajuan Suat Pengantar oleh {$pengaju?->name} telah disetujui oleh admin dan membuatuhkan persetujuan Kepala Dinas",
            ]);
        }
        Alert::success('Berhasil', 'Surat pengantar berhasil disetujui oleh admin.');
        return redirect()->back();
    }

    public function setujui($id)
    {
        $model = SuratPengantar::findOrFail($id);
        $model->status = "disetujui";
        $model->approved_at = now();
        $model->update();

        $link = "usulan/surat-pengantar/" . $model->id;


        Notification::create([
            'user_id' => $model->user_id,
            'title' => "Pengajuan Surat Pengantar",
            "link" => $link,
            'text' => "Pengajuan Surta Pengantar telah disetujui Kepala Dinas"
        ]);
        Activity::create([
            'user_id' => Auth::user()->id,
            'log' => "pengajuan surat pengantar disetujui oleh Kepala dinas",
            "type" => "success"
        ]);
        Alert::success('Berhasil', 'Surat pengantar telah disetujui.');
        return redirect()->back();
    }

    public function print($id)
    {
        $model = SuratPengantar::findOrFail($id);
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true])->setPaper('A4');
        $encryptedId = base64_encode($model->id);
        $qrCode = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate(url("/surat-pengantar/{$encryptedId}")));
        $pdf->loadView('pdf.suratPengantar', ["model" => $model, "perihal" => "Surat Pengantar", "qrCode" => $qrCode]);
        return $pdf->stream('Surat Pengantar.pdf');
    }
}
