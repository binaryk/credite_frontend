<!-- BEGIN SLIDER -->
  <div class="page-slider margin-bottom-40">
    <div class="fullwidthbanner-container revolution-slider">
      <div class="fullwidthabnner">
        <ul id="revolutionul">
          <!-- THE NEW SLIDE -->
          <!-- THE THIRD SLIDE -->
            @if(count($comments) > 0)
                <h3>Reviews</h3>
                @foreach($comments as $k => $comment)
                    <li class="comment" data-thumb="{{ asset('assets/frontend/pages/img/revolutionslider/thumbs/thumb2.jpg') }}">
                      <div class="text">
                          {!! $comment->message !!}
                      </div>
                    </li>
                @endforeach
            @endif
              </ul>
              <div class="tp-bannertimer tp-bottom"></div>
          </div>
      </div>
  </div>
  <!-- END SLIDER -->