<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index()
    {
        $query = User::query();

        if (request('role')) {
            $query->where('role', request('role'));
        }

        if (request('status')) {
            if (request('status') == 'suspended') {
                $query->where('is_suspended', 1);
            } elseif (request('status') == 'active') {
                $query->where('is_suspended', 0);
            }
        }

        $users = $query->orderBy('role', 'asc')->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function loginAsUser(User $user)
    {
        session(['admin_id' => Auth::id()]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', "You are now logged in as {$user->name}");
    }

    public function loginAsAdminBack()
    {
        if (session('admin_id')) {
            $admin = User::find(session('admin_id'));
            Auth::login($admin);
            session()->forget('admin_id');

            return redirect('/admin/dashboard')->with('success', 'Back to admin account.');
        }

        return redirect('/')->with('error', 'Admin session not found.');
    }

    public function toggleSuspend(User $user)
    {
        if (auth()->id() == $user->id) {
            return back()->with('error', 'You cannot suspend yourself.');
        }

        $user->is_suspended = !$user->is_suspended;
        $user->save();

        return back()->with('success', 'User status updated successfully.');
    }
}
