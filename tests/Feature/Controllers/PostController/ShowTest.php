<?php

use function Pest\Laravel\get;

it('Can show a Post', function () {
    $post = \App\Models\Post::factory()->create();

    get(route('posts.show', $post))->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = \App\Models\Post::factory()->create();
    $post->load('user');
    get(route('posts.show', $post))->assertHasResource('post', \App\Http\Resources\PostResource::make($post));
});


it('passes comments to the view', function(){
    $post = \App\Models\Post::factory()->create();

    $comment = \App\Models\Comment::factory(2)->for($post)->create();
    $comment->load('user');
    get(route('posts.show', $post))->assertHasPaginatedResource('comment', \App\Http\Resources\CommentResource::collection($comment->reverse()));

});
