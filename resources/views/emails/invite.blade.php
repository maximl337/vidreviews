@if($invite->message)
{{ $invite->message }}
@else
Hello,
{{ $user->name }} has requested a video review from you. Please click on the link below to add one. This will only take a few minutes.
@if($url)
<a href="{{ $url }}" alt="Link to accept invite">{{ $url }}</a>
@endif
@endif
