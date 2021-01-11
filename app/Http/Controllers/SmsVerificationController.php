<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Verify\Service;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use App\Services\Twilio\Verification as TwilioVerification;

class SmsVerificationController extends Controller
{

    use RedirectsUsers;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * Verification service
     *
     * @var Service
     */
    protected $verify;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->verify = new TwilioVerification;

        $this->middleware('auth');
//        $this->middleware('signed')->only('verify');
//        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the phone verification form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedPhone()
            ? redirect($this->redirectPath())
            : view('sms.verify');
    }

    /**
     * Mark the authenticated user's phone number as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedPhone()) {
            return redirect($this->redirectPath());
        }

        $code = $request->post('code');
        $phone = '+1' . preg_replace('/\D/', '', $request->user()->phone);
        $verification = $this->verify->checkVerification($phone, $code);

        if ($verification->isValid()) {
            $request->user()->markPhoneAsVerified();
            return redirect($this->redirectPath());
        }

        $errors = new MessageBag();
        foreach ($verification->getErrors() as $error) {
            $errors->add('verification', $error);
        }

        return view('sms.verify')->withErrors($errors);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedPhone()) {
            return redirect($this->redirectPath());
        }

        $phone = '+1' . preg_replace('/\D/', '', $request->user()->phone);
        $channel = $request->post('channel', 'sms');
        $verification = $this->verify->startVerification($phone, $channel);

        if (!$verification->isValid()) {

            $errors = new MessageBag();
            foreach($verification->getErrors() as $error) {
                $errors->add('verification', $error);
            }

            return redirect('/sms/verify')->withErrors($errors);
        }

        $messages = new MessageBag();
        $messages->add('verification', "Another code sent to {$request->user()->phone}");

        return redirect('/sms/verify')->with('messages', $messages);
    }
}
