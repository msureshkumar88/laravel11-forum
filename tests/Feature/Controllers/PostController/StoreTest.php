<?php
use function Pest\Laravel\{post, actingAs};
use App\Models\{User, Post};

beforeEach(function () {
    $this->validData = fn() => [
        'title' => 'Hello World',
        'topic_id' => \App\Models\Topic::factory()->create()->getKey(),
        'body' => 'This is my very first post! This is my very first post!This is my very first post!This is my very first post!This is my very first post!This is my very first post!This is my very first post!'
    ];
});

it('requires authentication', function (){
    post(route('posts.store'))->assertRedirect(route('login'));
});

it('stores a post', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $data = value($this->validData);

    actingAs($user)->post(route('posts.store'), $data);


    $this->assertDatabaseHas(Post::class, [
        ...$data,
        'user_id' => $user->id,
    ]);
});

it('redirects to post show page', function () {

    $user = User::factory()->create();

    actingAs($user)->post(route('posts.store'), value($this->validData))
        ->assertRedirect(Post::latest('id')->first()->showRoute());

});

it('requires valid data', function (array $badData, array|string $errors) {
    $this->dataSetAsStringWithData();
    actingAs(User::factory()->create())
        ->post(route('posts.store'), [...value($this->validData), ...$badData])
        ->assertInvalid($errors);

})->with([
    [['title' => null], 'title'],
    [['title' => true], 'title'],
    [['title' => 1], 'title'],
    [['title' => 1.5], 'title'],
    [['title' => str_repeat('a', 121)], 'title'],
    [['title' => str_repeat('a', 9)], 'title'],
    [['topic_id' => null], 'topic_id'],
    [['topic_id' => -1], 'topic_id'],
    [['body' => null], 'body'],
    [['body' => true], 'body'],
    [['body' => 1], 'body'],
    [['body' => 1.5], 'body'],
    [['body' => str_repeat('a', 10_001)], 'body'],
    [['body' => str_repeat('a', 99)], 'body'],
]);
