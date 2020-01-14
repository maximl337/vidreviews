@extends('layouts.app')

@section('content')
@component('components._status')
@endcomponent
<section class="jumbotron text-center">
<div class="container">
    <h1 class="jumbotron-heading">Invite</h1>
</div>
</section>
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <form method="POST" action="{{ route('send-invite') }}">
                @csrf
                <div class="form-group row">
                    <label for="invitee_email" class="col-md-4 col-form-label text-md-right">E-mail address</label>

                    <div class="col-md-6">
                        <input id="invitee_email" type="email" class="form-control @error('invitee_email') is-invalid @enderror" name="email" value="{{ old('invitee_email') }}" required autocomplete="email" autofocus>

                        @error('invitee_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="message" class="col-md-4 col-form-label text-md-right"> Message (optional)</label>

                    <div class="col-md-6">
                        <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message" rows="5" style="resize: none;" placeholder="{!! $placeholder !!}"></textarea>

                        @error('message')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
