@component('mail::message')
    <h1>Mail Test</h1><br>
    <h3>Hello {{$data['username']}},</h3>
    @component('mail::button', ['url' =>'mailto:'.env('MAIL_USERNAME')])
        Reply!
    @endcomponent

    Thanks,{{ config('app.name') }}

@endcomponent
