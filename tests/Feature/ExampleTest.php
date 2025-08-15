<?php

test('Categories route returns a successful response', function () {
    $response = $this->get(route('categories'));

    $response->assertStatus(200);
});
