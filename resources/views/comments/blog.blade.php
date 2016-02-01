<div class="main">
    <div class="container">
        <div class="row margin-bottom-40">
            <div class="col-md-12 col-sm-12">
                <h3>Pagina de feedback</h3>
                <br>
                <div class="content-page">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 blog-posts">

                            @foreach($comments as $k => $comment)
                                <hr class="blog-post-sep">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <img src="{!! asset('img/default-avatar.png') !!}" alt="Default avatar" height="50" style="width:50px; border:0; float: right;">
                                    </div>
                                    <div class="col-md-8 col-sm-8">
                                        <h2><a href="blog-item.html">{!! $comment->title !!}</a></h2>
                                        <ul class="blog-info">
                                            <li><i class="fa fa-calendar"></i> {!! $comment->created_at !!}</li>
                                            <li><i class="fa fa-comments"></i> {!! count($comments) !!} </li>
                                            <li><i class="fa fa-tags"></i> {!! $comment->author . ', ' .$comment->email !!}</li>
                                        </ul>
                                        <p> {!! $comment->message !!} </p>
                                    </div>
                                </div>
                                <hr class="blog-post-sep">
                            @endforeach



                            @include('comments.form')
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
</div>