<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    public function data(Request $request)
    {
        $unit = Jabatan::with("user");

        return DataTables::of($unit)
            ->addIndexColumn()
            ->addColumn('user', function ($jabatan) {
                return $jabatan->user->name;
            })
            ->addColumn('action', function ($jabatan) {
                return view('jabatan.action', ['item' => $jabatan])->render();
            })
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $query->where('nama', 'like', '%' . $request->search['value'] . '%');
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
        return view("jabatan.index", ["title" => "Jabatan Penandatangan"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select("id", "name")->get();
        return view('jabatan.create', ["title" => "Tambah Jabatan", "isTitleCenter" => true, "users" => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nama" => "required|string|max:255",
            "user_id" => "required|exists:users,id"
        ]);

        Jabatan::create($request->all());
        Alert::success('Berhasil', 'Jabatan berhasil ditambahkan');
        return redirect()->route("jabatan.index");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $users = User::select("id", "name")->get();
        return view('jabatan.edit', ["title" => "Edit Jabatan", "isTitleCenter" => true, "model" => $jabatan, "users" => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "nama" => "required|string|max:255",
            "user_id" => "required|exists:users,id"
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());
        Alert::success('Berhasil', 'Jabatan berhasil diperbarui');
        return redirect()->route("jabatan.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        Alert::success('Berhasil', 'Jabatan berhasil dihapus');
        return redirect()->route("jabatan.index");
    }
}
