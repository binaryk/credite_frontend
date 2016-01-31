@if(count($comments) > 0)
<div class="col-md-12 testimonials-v1">
    <h2>Clients Testimonials</h2>
    <div id="myCarousel1" class="carousel slide">
        <!-- Carousel items -->
        <div class="carousel-inner">
            @foreach($comments as $k => $comment)
            <div class="@if($k==0) active @endif item">
                <blockquote>
                    <h4>{!! $comment->title !!}</h4>
                    <p>
                        {!! $comment->message !!}
                    </p></blockquote>
                <div class="carousel-info">
                    <img class="pull-left" src="{{ asset('img/default-avatar.png') }}" alt="">
                    <div class="pull-left">
                        <span class="testimonials-name">{!! $comment->author !!}</span>
                        <span class="testimonials-post">{!! $comment->created_at !!}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Carousel nav -->
        <a class="left-btn" href="#myCarousel1" data-slide="prev"></a>
        <a class="right-btn" href="#myCarousel1" data-slide="next"></a>
    </div>
</div>
@endif