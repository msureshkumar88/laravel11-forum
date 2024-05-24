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
