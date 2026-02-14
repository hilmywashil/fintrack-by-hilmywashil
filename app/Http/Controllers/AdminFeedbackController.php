<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminFeedbackController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $feedbacks = Feedback::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.feedback.index', compact('feedbacks', 'keyword'));
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

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback berhasil dihapus.');
    }
}
