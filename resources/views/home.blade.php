@extends('layouts.app')

@section('content')
<section class="jumbotron text-center">
<div class="container">
    <h1 class="jumbotron-heading">Testimonials</h1>
    <div class="row justify-content-center">
    <div class="col-md-4">
        <div class="media mt-4 pl-5 ml-5">
            <img class="mr-2" src="{{ $user['avatar'] }}" alt="Generic placeholder image" width="50">
            <div class="media-body text-left">
                <p class="mt-0">{{ $user['name'] }}</p>
            </div>
        </div>
    </div>
    </div>
</div>
</section>
@component('components._status')
@endcomponent
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-5 text-center">
                <h4>Invite someone to leave a review for you.</h4>
                <a class="btn btn-primary btn-sm" href="{{ route('invite') }}">Invite</a>
            </div>
    </div>
    @foreach(array_chunk($reviews, 3) as $reviewRow)
        <div class="row justify-content-center mb-4">
            @foreach($reviewRow as $review)
            <div class="col-md-4">
                @component('components.review', ['review' => $review])
                @endcomponent
            </div>
            @endforeach
        </div>
    @endforeach
    @if(!count($reviews))
        <h5 class="text-center text-muted">No testimonials yet!</h5>
    @endif
</div>
@endsection
