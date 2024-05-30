<?php

use function Pest\Laravel\get;

it('Can show a Post', function () {
    $post = \App\Models\Post::factory()->create();

    get($post->showRoute())->assertComponent('Posts/Show');
});

it('passes a post to the view', function () {
    $post = \App\Models\Post::factory()->create();
    $post->load('user');
    get($post->showRoute())->assertHasResource('post', \App\Http\Resources\PostResource::make($post));
});


it('passes comments to the view', function(){
    $post = \App\Models\Post::factory()->create();

    $comment = \App\Models\Comment::factory(2)->for($post)->create();
    $comment->load('user');
    get($post->showRoute())->assertHasPaginatedResource('comments', \App\Http\Resources\CommentResource::collection($comment->reverse()));

});

it('will redirect if the slug is incorrect', function () {
    $post = \App\Models\Post::factory()->create(['title' => 'Hello world']);

    get(route('posts.show', [$post, 'foo-bar', 'page' => 2]))
        ->assertRedirect($post->showRoute(['page' => 2]));
});
