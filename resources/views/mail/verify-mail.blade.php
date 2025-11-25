<x-mail::message>
# Verify User

@if(isset($data['name']))
<strong> Name </strong> : {{ $data['name'] }}<br>
@endif

@if(isset($data['remember_token']))
  Please click the below link to verify your account
@endif

<x-mail::button :url="route('verify-seller',['token'=>$data['remember_token']??''])">
Verify Now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
