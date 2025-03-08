<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UnitKerjaController extends Controller
{
    public function data(Request $request)
    {
        $unit = UnitKerja::query();

        return DataTables::of($unit)
            ->addIndexColumn()
            ->addColumn('action', function ($unit) {
                return view('unit.action', ['item' => $unit])->render();
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $query->where('name', 'like', '%' . $request->search['value'] . '%');
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("unit.index", ["title" => "Unit Kerja"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("unit.create", ["title" => "Tambah Unit Kerja", "isTitleCenter" => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nama" => "required|string|max:255",
        ]);

        UnitKerja::create($request->all());
        Alert::success('Berhasil', 'Unit Kerja berhasil ditambahkan');
        return redirect()->route("unit.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unit = UnitKerja::find($id);
        return view("unit.edit", ["title" => "Edit Unit Kerja", "isTitleCenter" => true, "model" => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            "nama" => "required|string|max:255",
        ]);

        $unit = UnitKerja::find($id);
        $unit->update($request->all());
        Alert::success('Berhasil', 'Unit Kerja berhasil diperbarui');
        return redirect()->route("unit.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = UnitKerja::find($id);
        $unit->delete();
        Alert::success('Berhasil', 'Unit Kerja berhasil dihapus');
        return redirect()->route("unit.index");
    }
}
