<?php

namespace App\Http\Controllers;

use App\Models\SuratCuti;
use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsulanController extends Controller
{

    public function index(Request $request)
    {
        $model = collect();
        $userRole = Auth::user()->role;
        // Surat Cuti
        $suratCuti = SuratCuti::with('pengaju');
        $suratCuti->where(function ($query) use ($userRole) {
            $query->where('status', 'disetujui_admin');
            if ($userRole == 'admin' || $userRole == 'user') {
                $query->orWhere('status', 'menunggu');
            }
        });

        if ($userRole == 'user') {
            $suratCuti->where("user_id", Auth::user()->id);
        }
        $model = $model->merge($suratCuti->orderBy("created_at", "desc")->get());
        // end Surat Cuti

        // Surat Pengantar
        $suratPengantar = SuratPengantar::with('pengaju');
        $suratPengantar->where(function ($query) use ($userRole) {
            $query->where('status', 'disetujui_admin');
            if ($userRole == 'admin' || $userRole == 'user') {
                $query->orWhere('status', 'menunggu');
            }
        });

        if ($userRole == 'user') {
            $suratPengantar->where("user_id", Auth::user()->id);
        }
        $model = $model->merge($suratPengantar->orderBy("created_at", "desc")->get());
        // end Surat Pengantar
        return view('usulan.index', ['title' => 'Usulan', 'model' => $model]);
    }

    public function riwayat(Request $request)
    {
        $model = collect();
        $userRole = Auth::user()->role;
        // Surat Cuti
        $suratCuti = SuratCuti::with('pengaju');
        $suratCuti->where(function ($query) {
            $query->where('status', 'ditolak')->orWhere('status', 'disetujui');
        });

        if ($userRole == 'user') {
            $suratCuti->where("user_id", Auth::user()->id);
        }
        $model = $model->merge($suratCuti->orderBy("created_at", "desc")->get());
        return view('usulan.riwayat', ['title' => 'Usulan', 'model' => $model]);
    }
}
