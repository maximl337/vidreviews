@extends('layouts.app')
@section('content')
<section class="jumbotron text-center">
<div class="container">
    <h1 class="jumbotron-heading">Invite</h1>
</div>
</section>
@component('components._status')
@endcomponent
<div class="container">
    <div class="row justify-content-center mb-4">
        <div id="dynamic-height" class="col-md-8 col-md-offset-2 text-center">
            <ziggeo  ziggeo-limit=15>
            </ziggeo>
        </div>
        <div class="col-md-8 col-md-offset-2 text-center">
            {{-- <ziggeoplayer id="ziggeo-player" ziggeo-video=""></ziggeoplayer> --}}
            <form id="submit-review-form" action="{{ route('submit-review') }}" method="POST" class="d-none">
                @csrf
                <input name="invite_id" type="hidden" value="{{ $invite->id }}" required="required" />
                <input id="ziggeo-token" name="ziggeo_token" type="hidden" value="" required="required" />
                <div class="form-control">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
(function() {
    ZiggeoApi.Events.on("submitted", function (data) {
        console.log(data.video);
        //alert("The video with token " + data.video.token + " has been submitted!");
        var tokenInput = document.getElementById("ziggeo-token");
        tokenInput.value = data.video.token;
        var form = document.getElementById("submit-review-form");
        form.submit();
    });


})();
</script>
@endsection
