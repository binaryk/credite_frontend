<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class AdminCommentsController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $comments = Comment::all();
        return view('administration.messages')->with(compact('comments'));
    }

    public function validation()
    {
        $id = Input::get('id');
        if(! $comment = Comment::find($id) ){
            throw new Exception('Comment not found => id: '.$id);
        }

        $comment->valid = !$comment->valid;
        $comment->save();
        return $comment;
    }


}
