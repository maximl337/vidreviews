<div class="card review-card">
    <div class="card-body">
        <div class="text-right">
            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
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
