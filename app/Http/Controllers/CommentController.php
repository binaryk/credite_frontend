<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $comments = Comment::where('valid','1')->get();
        return view('comments.index')->with(compact('comments'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        Comment::create([
            'author' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'title' => $data['title']
        ]);
        return view('comments.alert')->with(['message' => trans('strings.comment')])->render();
    }
}
