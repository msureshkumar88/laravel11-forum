<?php

use App\Models\Topic;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\get;


it('should return correct component', function () {
    get(route('posts.index'))
        ->assertInertia(fn(AssertableInertia $inertia) => $inertia
            ->component('Posts/Index', true));
});

it('passes posts to the view', function () {
    $posts = \App\Models\Post::factory(3)->create();

    $posts->load(['user' , 'topic']);

    get(route('posts.index'))
        ->assertHasPaginatedResource('posts', \App\Http\Resources\PostResource::collection($posts->reverse()));
});

it('it can filter a topic', function () {
    $this->withoutExceptionHandling();
    $general = Topic::factory()->create();
    $posts = \App\Models\Post::factory(2)->for($general)->create();

    $otherPosts = \App\Models\Post::factory(3)->create();

    $posts->load(['user' , 'topic']);

    get(route('posts.index', ['topic' => $general]))
        ->assertHasPaginatedResource('posts', \App\Http\Resources\PostResource::collection($posts->reverse()));
});

it('can filter to a topic', function () {
    $general = Topic::factory()->create();
    $posts = \App\Models\Post::factory(2)->for($general)->create();
    $otherPosts = \App\Models\Post::factory(3)->create();

    $posts->load(['user', 'topic']);

    get(route('posts.index', ['topic' => $general]))
        ->assertHasPaginatedResource('posts', \App\Http\Resources\PostResource::collection($posts->reverse()));
});

it('passes the selected topic to the view', function () {
    $topic = Topic::factory()->create();

    get(route('posts.index', ['topic' => $topic]))
        ->assertHasResource('selectedTopic', \App\Http\Resources\TopicResource::make($topic));
});

