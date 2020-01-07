@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-5">Testimonials</h1>
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
