<x-mail::message>
# Enquiry

@if(isset($data['name']))
<strong> Name </strong> : {{ $data['name'] }}<br>
@endif
@if(isset($data['phone']))
<strong> Mobile Number</strong> : {{ $data['phone'] }}<br>
@endif
@if(isset($data['email']))
    <strong> Email</strong> : {{ $data['email'] }}<br>
@endif
@if(isset($data['subject']))
    <strong>subject</strong> : {{ $data['subject'] }}<br>
@endif
@if(isset($data['trip_details']))
    <strong>Trip Details</strong> : {{ $data['trip_details'] }}<br>
@endif
@if(isset($data['message']))
    <strong> Message</strong> : {{ $data['message'] }}<br>
@endif



<x-mail::button :url="route('index')">
Back to {{ config('app.name') }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
