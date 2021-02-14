@component('mail::message')
# This is a TEST message

This is a test, it is only a test. If this were a real emergency....

<img src="{!!$message->embedData(QrCode::format('png')->generate('https://bossquatch.com'), 'QrCode.png', 'image/png')!!}">

@component('mail::button', ['url' => config('app.url') . '/home','color' => 'doug'])
Login to your account
@endcomponent

@endcomponent
