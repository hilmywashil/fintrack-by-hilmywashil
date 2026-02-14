<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Tampilkan halaman form
    public function index()
    {
        return view('feedback.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'message' => 'required|string'
        ]);

        $feedback = Feedback::create(
            $request->only('name', 'email', 'message')
        );

        Mail::to('fintracks.app@gmail.com')
            ->send(new FeedbackMail($feedback));

        return redirect()
            ->route('feedback.index')
            ->with('success', 'Terima kasih! Feedback berhasil dikirim.');
    }
}
