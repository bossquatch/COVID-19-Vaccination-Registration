<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:read_registration']);
    }

    public function store()
    {
        if (!request()->filled('comment') || !request()->filled('regis_id')) {
            return json_encode(['status' => 'failed']);    
        }

        $registration = \App\Models\Registration::findOrFail(request()->input('regis_id'));
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'registration_id' => $registration->id,
            'text' => request()->input('comment'),
        ]);

        $this->logChanges($comment, 'created');

        return json_encode(['status' => 'success', 'html' => view('manage.partials.comments', ['comments' => $registration->comments])->render()]);
    }

    public function delete($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $registration = $comment->registration;

        $this->logChanges($comment, 'deleted');

        $comment->delete();

        return json_encode(['status' => 'success', 'html' => view('manage.partials.comments', ['comments' => $registration->comments])->render()]);
    }
}
