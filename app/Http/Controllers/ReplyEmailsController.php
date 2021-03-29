<?php

namespace App\Http\Controllers;

use App\Models\EmailReply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReplyEmailsController extends Controller
{
    public function index()
    {
    	$current_emails = EmailReply::all();

    	return view('mail.replyemails')->with(
    		compact('current_emails'));

    }

    public function destroy($email_id): JsonResponse
    {
		$current_email = EmailReply::findOrFail($email_id);
		$current_email->delete();
	    Session::flash('info', 'The email was deleted successfully!');
		return response()->json([
			'message' => 'email deleted successfully!'
		]);
    }

    public function getHTML($email_id): string
    {
    	$current_email = EmailReply::findOrFail($email_id);
	    return $current_email->body_html;
    }
}
