<?php

    get('terms-conditions', ['as' => 'terms_conditions', 'uses' => 'StaticController@terms' ]);
    get('reviews', ['as' => 'comments', 'uses' => 'CommentController@index' ]);
    post('reviews', ['as' => 'comment.submit', 'uses' => 'CommentController@save' ]);
