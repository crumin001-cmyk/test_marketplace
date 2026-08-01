<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request,  $item_id)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
}
