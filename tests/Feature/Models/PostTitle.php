<?php

it('uses title case for titles',function (){
    $post = \App\Models\Post::factory()->create(['title' => 'Hello, how are you']);

    expect($post->title)->toBe('Hello, How Are You');
});
