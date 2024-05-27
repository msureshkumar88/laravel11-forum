<?php

use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\get;


it('should return correct component', function () {
    get(route('posts.index'))
        ->assertInertia(fn(AssertableInertia $inertia) => $inertia
            ->component('Posts/Index', true));
});

it('passes posts to the view', function () {
    $posts = \App\Models\Post::factory(3)->create();

    $posts->load('user');

    get(route('posts.index'))
        ->assertHasPaginatedResource('posts', \App\Http\Resources\PostResource::collection($posts->reverse()));
});
