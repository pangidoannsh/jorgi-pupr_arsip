<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Arsip;
use App\Models\SuratCuti;
use App\Models\SuratPengantar;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        $usulan = collect();
        // ====== Surat Cuti ======
        $suratCutiQuery = SuratCuti::select("status", "created_at", "approved_at")->whereDate('created_at', '>=', now()->subDays(7));

        if ($user->role === "user") {
            $suratCutiQuery->where("user_id", $userId);
        }

        $usulan = $usulan->merge($suratCutiQuery->get());

        $totalSuratCuti = SuratCuti::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))->count();
        $totalSuratCutiDisetujui = SuratCuti::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))
            ->where("status", "disetujui")
            ->count();
        // ====== end Surat Cuti ======

        // ====== Surat Pengantar ======
        $suratPengantarQuery = SuratPengantar::select("status", "created_at", "approved_at")->whereDate('created_at', '>=', now()->subDays(7));

        if ($user->role !== "admin") {
            $suratPengantarQuery->where("user_id", $userId);
        }

        $usulan = $usulan->merge($suratPengantarQuery->get());

        $totalSuratPengantar = SuratPengantar::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))->count();
        $totalSuratPengantarDisetujui = SuratPengantar::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))
            ->where("status", "disetujui")
            ->count();
        // ====== end Surat Pengantar ======

        $arsip = Arsip::whereDate('created_at', '>=', now()->subDays(7))->get();
        $activities = Activity::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))->orderBy("created_at", "desc")->limit(5)->get();
        return view('index', [
            'title' => 'Dashboard',
            "usulan" => $usulan,
            "arsip" => $arsip,
            "totalUsulan" => $totalSuratCuti + $totalSuratPengantar,
            "totalUsulanDisetujui" => $totalSuratCutiDisetujui + $totalSuratPengantarDisetujui,
            "totalArsip" => Arsip::count(),
            "activities" => $activities
        ]);
    }
}
