@component('mail::message')
# Hi, {{$name}}

You can recover your password via this link

<a href="http://127.0.0.1:8000?token={{$token}}&email={{$email}}">http://127.0.0.1:8000?token={{$token}}&email={{$email}}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
