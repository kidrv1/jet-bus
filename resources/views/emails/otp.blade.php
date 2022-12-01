@component('mail::message')
# Welcome To Jet Bus Travel and Tours

Your OTP is `696969`

@component('mail::button', ['url' => '/'])
Ok
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
