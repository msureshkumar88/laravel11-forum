<?php

it('generates the html', function () {
    $comment = \App\Models\Comment::factory()->make(['body' => '## Hello world']);

    $comment->save();

    expect($comment->html)->toEqual(str($comment->body)->markdown());
});
