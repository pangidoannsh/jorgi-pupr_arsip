<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Klasifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ArsipController extends Controller
{

    protected $upload_path = 'uploads/arsip/';

    public function data(Request $request)
    {
        $arsip = Arsip::with(['klasifikasi', 'user']);
        if ($request->get('klasifikasi', "") != "") {
            $arsip->where('kode_klasifikasi', $request->kode_klasifikasi);
        }
        if ($request->get('user', "") != "") {
            $arsip->where('user_created', $request->user);
        }

        return DataTables::of($arsip)
            ->addIndexColumn()
            ->editColumn('nomor_berkas', function ($report) {
                return $report->nomor_berkas;
            })
            ->addColumn('nomor_arsip', function ($report) {
                return $report->nomor_arsip;
            })
            ->addColumn('klasifikasi', function ($report) {
                return $report->klasifikasi->nama ?? '-';
            })
            ->addColumn('user', function ($report) {
                return $report->user->name ?? '-';
            })
            ->addColumn('action', function ($report) {
                return view('arsip.action-button', ['item' => $report])->render();
            })
            ->editColumn('kurun_waktu', function ($report) {
                return Carbon::parse($report->tanggal_mulai)->translatedFormat('d M Y') . " - " . Carbon::parse($report->tanggal_selesai)->translatedFormat('d M Y');
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $query->where('name', 'like', '%' . $request->search['value'] . '%');
                }
            })
            ->rawColumns(['action', 'name'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("arsip.index", ["title" => "Arsip Dokumen"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $klasifikasi = Klasifikasi::select("kode_klasifikasi", "nama")->get();
        return view("arsip.create", ['title' => 'Tambah Arsip', 'isTitleCenter' => true, 'klasifikasi' => $klasifikasi]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:255',
            'nomor_berkas' => 'required|string|max:255',
            'nomor_arsip' => 'required|string|max:255',
            'uraian_informasi' => 'required|string|max:500', // Disesuaikan dengan kebutuhan
            'file_upload' => 'nullable|file|max:2048|required_without:url_file', // Harus diisi jika url_file kosong
            'url_file' => 'nullable|required_without:file_upload', // Harus diisi jika file kosong
            'jumlah' => 'required|integer|min:1',
            'tingkat_perkembangan' => 'required|string|max:255',
            'keterangan_nomor_box' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_selesai',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'file_upload.required_without' => 'File harus diunggah jika URL file tidak diisi.',
            'url_file.required_without' => 'URL file harus diisi jika file tidak diunggah.',
        ]);
        $file = $request->file('file_upload');

        if ($file) {
            $request->merge(['file' => FileController::store($file, $this->upload_path)]);
        }

        $request->merge([
            'user_created' => Auth::user()->id,
        ]);

        Arsip::create($request->all());

        Alert::success('Berhasil', 'Arsip berhasil ditambahkan');
        return redirect()->route("arsip.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Arsip $arsip)
    {
        return view("arsip.show", ['model' => $arsip]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arsip $arsip)
    {
        $klasifikasi = Klasifikasi::select("kode_klasifikasi", "nama")->get();
        return view("arsip.edit", ['title' => 'Edit Arsip', 'isTitleCenter' => true, 'model' => $arsip, 'klasifikasi' => $klasifikasi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Arsip $arsip)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:255',
            'nomor_berkas' => 'required|string|max:255',
            'nomor_arsip' => 'required|string|max:255',
            'uraian_informasi' => 'required|string|max:500',
            'jumlah' => 'required|integer|min:1',
            'tingkat_perkembangan' => 'required|string|max:255',
            'keterangan_nomor_box' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_selesai',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $file = $request->file('file_upload');
        if ($file) {
            // Hapus file lama jika ada
            FileController::delete($arsip->file);
            // Menyimpan file baru
            $request->merge(['file' => FileController::store($file, $this->upload_path)]);
        }

        $arsip->update($request->all());

        Alert::success('Berhasil', 'Arsip berhasil diperbarui');
        return redirect()->route("arsip.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arsip $arsip)
    {
        FileController::delete($arsip->file);
        $arsip->delete();
        Alert::success('Berhasil', 'Arsip berhasil dihapus');
        return redirect()->route("arsip.index");
    }
}
