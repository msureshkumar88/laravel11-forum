<?php

it('', function () {

});
it('requires authentication', function (){
    \Pest\Laravel\delete(route('comments.destroy',
        \App\Models\Comment::factory()->create()))->assertRedirect('login');
});

it('can delete a comment', function () {
    $comment = \App\Models\Comment::factory()->create();
    \Pest\Laravel\actingAs($comment->user)->delete(route('comments.destroy', $comment));
    $this->assertModelMissing($comment);
});

it('redirects to the post show page', function () {
    $comment = \App\Models\Comment::factory()->create();
    \Pest\Laravel\actingAs($comment->user)->delete(route('comments.destroy', $comment))
    ->assertRedirect(route('posts.show', $comment->post_id));
});

it('prevents deleting a comment you didnt create', function () {
    $comment = \App\Models\Comment::factory()->create();
    \Pest\Laravel\actingAs(\App\Models\User::factory()->create())->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});

it('prevents deleting a comment posted an hour ago', function () {
    $this->freezeTime();
    $comment = \App\Models\Comment::factory()->create();
    $this->travel(1)->hour();
    \Pest\Laravel\actingAs(\App\Models\User::factory()->create())->delete(route('comments.destroy', $comment))
        ->assertForbidden();
});

