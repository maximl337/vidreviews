<div class="card review-card">
    <div class="card-body">
        <div class="text-right mb-2">
            @if($review['user_id'] == auth()->id())
                @if(empty($review['approved_at']))
                    <form method="POST" action="{{ route('approve') }}">
                    @csrf
                        <input type="hidden" name="review_id" value="{{ $review['id'] }}" />
                        <input type="submit" class="btn btn-sm btn-primary" value="Approve">
                    </form>
                @else
                    <form method="POST" action="{{ route('disapprove') }}">
                    @csrf
                        <input type="hidden" name="review_id" value="{{ $review['id'] }}" />
                        <input type="submit" class="btn btn-sm btn-primary" value="Disapprove">
                    </form>
                @endif
            @endif
        </div>
        <div class="card-img-top" alt="Card image cap">
            <img src="{{ $review['video_url'] }}" />
        </div>
        <div class="media mt-4">
            <img class="mr-3" src="{{ $review['reviewer']['avatar'] }}" alt="Generic placeholder image" width="50">
            <div class="media-body">
                <p class="mt-0">{{ $review['reviewer']['name'] }}</p>
            </div>
        </div>
    </div>
</div>
