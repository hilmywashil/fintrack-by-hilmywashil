<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function loginActivity(Request $request)
    {
        $query = LoginActivity::where('user_id', auth()->id());

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('ip_address', 'like', '%' . $request->keyword . '%')
                    ->orWhere('device', 'like', '%' . $request->keyword . '%');
            });
        }

        $activities = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('settings.login-activity', compact('activities'));
    }

    public function clearLoginActivity()
    {
        LoginActivity::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Riwayat login berhasil dibersihkan.');
    }
}
