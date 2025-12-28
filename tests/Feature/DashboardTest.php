<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $this->get(route('/'))->assertRedirect(route('login'));
});

test('authenticated users can visit the welcome page', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get(route('/'))->assertOk();
});