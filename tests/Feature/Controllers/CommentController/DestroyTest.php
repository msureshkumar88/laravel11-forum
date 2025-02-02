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
    $this->withoutExceptionHandling();
    $comment = \App\Models\Comment::factory()->create();
    \Pest\Laravel\actingAs($comment->user)->delete(route('comments.destroy', $comment))
        ->assertRedirect($comment->post->showRoute());
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

it('redirects to the post show page with page query parameter', function () {
    $comment = \App\Models\Comment::factory()->create();
    \Pest\Laravel\actingAs($comment->user)->delete(route('comments.destroy', ['comment'=>$comment, 'page' => 2]))
        ->assertRedirect($comment->post->showRoute(['page' => 2]));
});
