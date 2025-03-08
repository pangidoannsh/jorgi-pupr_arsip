<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    protected $upload_path = 'uploads/user/';

    public function data(Request $request)
    {
        $users = User::with(['unit']);
        if ($request->get('role', "") != "") {
            $users->where('role', $request->role);
        }
        if ($request->get('unit', "") != "") {
            $users->where('unit_id', $request->unit);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('unit', function ($user) {
                return $user->unit->nama ?? '-';
            })
            ->addColumn('action', function ($user) {
                return view('users.action', ['item' => $user])->render();
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
        if (Auth::user()->role == 'user') {
            Alert::error('Error', 'Anda tidak memiliki akses ke halaman ini');
            return redirect("/");
        }
        $units = UnitKerja::select("id", "nama")->get();
        return view("users.index", ['title' => 'Daftar User', "units" => $units]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role == 'user') {
            Alert::error('Error', 'Anda tidak memiliki akses ke halaman ini');
            return redirect("/");
        }
        $units = UnitKerja::select("id", "nama")->get();
        return view("users.create", ['title' => 'Tambah User', 'isTitleCenter' => true, 'units' => $units]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'name' => 'required|string|max:255',
            'jabatan' => 'required',
            'unit_id' => 'required',
            'role' => 'required',
            'password_input' => 'required',
            'ttd_upload' => 'required|image|mimes:png|max:2048',
        ]);
        $request->merge(['password' => bcrypt($request->password_input)]);
        $request->merge(['ttd' => FileController::store($request->file('ttd_upload'), $this->upload_path)]);

        User::create($request->all());
        Alert::success('Berhasil', 'User berhasil ditambahkan');
        return redirect()->route("users.index");
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $units = UnitKerja::select("id", "nama")->get();
        $model = User::findOrFail($id);
        return view("users.edit", ['title' => 'Detail User', 'isTitleCenter' => true, 'units' => $units, "model" => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required',
            'name' => 'required|string|max:255',
            'jabatan' => 'required',
            'unit_id' => 'required',
            'role' => 'required',
            'ttd_upload' => 'nullable|image|mimes:png|max:2048', // Tidak wajib
        ]);

        $user = User::findOrFail($id); // Ambil data user berdasarkan ID

        // Jika user menginputkan password, update password
        if ($request->filled('password_input')) {
            $request->merge(['password' => bcrypt($request->password_input)]);
        } else {
            $request->request->remove('password'); // Hapus dari request agar tidak ikut terupdate
        }

        // Jika ada file ttd yang diupload, update file lama
        if ($request->hasFile('ttd_upload')) {
            // Hapus file lama jika ada
            if ($user->ttd) {
                FileController::delete($user->ttd);
            }

            // Simpan file baru
            $path = FileController::store($request->file('ttd_upload'), $this->upload_path);
            $request->merge(['ttd' => $path]);
        } else {
            $request->request->remove('ttd'); // Hapus dari request agar tidak ikut terupdate
        }

        // Update data user
        $user->update($request->all());

        Alert::success('Berhasil', 'User berhasil diperbarui');
        return redirect()->route("users.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        FileController::delete($user->ttd);
        $user->delete();
        Alert::success('Berhasil', 'User berhasil dihapus');
        return redirect()->route("users.index");
    }
}
