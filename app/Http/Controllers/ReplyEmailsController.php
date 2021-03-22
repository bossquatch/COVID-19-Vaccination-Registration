<?php

namespace App\Http\Controllers;

use App\Models\EmailReply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReplyEmailsController extends Controller
{
    public function index()
    {
    	$current_emails = EmailReply::all();

    	return view('mail.replyemails')->with(
    		compact('current_emails'));

    }

    public function destroy($email_id): RedirectResponse
    {
		$current_email = EmailReply::findOrFail($email_id);
		$current_email->delete();
		return back()->with('success', 'The email was deleted.');
    }

    public function getHTML($email_id): string
    {
    	$current_email = EmailReply::findOrFail($email_id);
	    return $current_email->body_html;
//	    return back()->with('success', 'fuckyou');
    }
}
