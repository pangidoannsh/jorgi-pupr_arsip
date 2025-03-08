<?php

namespace App\Http\Controllers;

use App\Models\Klasifikasi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KlasifikasiController extends Controller
{

    public function data(Request $request)
    {
        $klasifikasi = Klasifikasi::query();
        return DataTables::of($klasifikasi)
            ->addIndexColumn()
            ->addColumn('kode_klasifikasi', function ($item) {
                return $item->kode_klasifikasi;
            })
            ->addColumn('nama', function ($item) {
                return $item->nama;
            })
            ->addColumn('action', function ($item) {
                return view('klasifikasi.action', ['item' => $item])->render();
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $query->where('nama', 'like', '%' . $request->search['value'] . '%');
                }
            })
            ->rawColumns(['action', 'nama'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("klasifikasi.index", ["title" => "Klasifikasi"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("klasifikasi.create", ["title" => "Tambah Klasifikasi", "isTitleCenter" => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        Klasifikasi::create($request->all());

        Alert::success('Berhasil', 'Klasifikasi berhasil ditambahkan');
        return redirect()->route("klasifikasi.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $klasifikasi = Klasifikasi::find($id);
        return view("klasifikasi.edit", ["title" => "Edit Klasifikasi", "isTitleCenter" => true, "model" => $klasifikasi]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        $klasifikasi = Klasifikasi::find($id);
        $klasifikasi->update($request->all());

        Alert::success('Berhasil', 'Klasifikasi berhasil diperbarui');
        return redirect()->route("klasifikasi.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $klasifikasi = Klasifikasi::find($id);
        $klasifikasi->delete();
        Alert::success('Berhasil', 'Klasifikasi berhasil dihapus');
        return redirect()->route("klasifikasi.index");
    }
}
