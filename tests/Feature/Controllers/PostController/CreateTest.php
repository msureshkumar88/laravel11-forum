<?php
use App\Models\User;
use function Pest\Laravel\{get, actingAs};
it('requires authentication', function (){
    get(route('posts.create'))->assertRedirect(route('login'));
});
it('returns the correct component', function (){
    actingAs(User::factory()->create())
    ->get(route('posts.create'))
    ->assertComponent('Posts/Create');
});
it('passes topics to the view', function () {
    $topics = \App\Models\Topic::factory(2)->create();

    actingAs(User::factory()->create())
        ->get(route('posts.create'))
        ->assertHasResource('topics', \App\Http\Resources\TopicResource::collection($topics));
});
