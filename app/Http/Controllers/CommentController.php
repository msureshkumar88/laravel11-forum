<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Policies\CommentPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {

        Comment::make($request->validate(['body' => ['required', 'string', 'max:2500']]))
            ->user()->associate($request->user())
            ->post()->associate($post)
            ->save();

        return to_route('posts.show', $post)
            ->banner('Comment added.');

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);
        $data = $request->validate(['body' => ['required', 'string', 'max:2500']]);

        $comment->update($data);

        return to_route('posts.show', ['post' => $comment->post_id, 'page' => $request->query('page')])
            ->banner('Comment updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        Gate::authorize('delete', $comment);
        $comment->delete();
        return to_route('posts.show', ['post'=>$comment->post_id, 'page'=>$request->query('page')])
            ->banner('Comment deleted.');

    }
}
