<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Arsip;
use App\Models\SuratCuti;
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

        if ($user->role !== "admin") {
            $suratCutiQuery->where("user_id", $userId);
        }

        $usulan = $usulan->merge($suratCutiQuery->get());
        // ====== end Surat Cuti ======

        $totalSuratCuti = SuratCuti::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))->count();
        $totalSuratCutiDisetujui = SuratCuti::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))
            ->where("status", "disetujui")
            ->count();

        $arsip = Arsip::whereDate('created_at', '>=', now()->subDays(7))->get();
        $activities = Activity::when($user->role !== "admin", fn($q) => $q->where("user_id", $userId))->orderBy("created_at", "desc")->limit(5)->get();
        return view('index', [
            'title' => 'Dashboard',
            "usulan" => $usulan,
            "arsip" => $arsip,
            "totalUsulan" => $totalSuratCuti,
            "totalUsulanDisetujui" => $totalSuratCutiDisetujui,
            "totalArsip" => Arsip::count(),
            "activities" => $activities
        ]);
    }
}
