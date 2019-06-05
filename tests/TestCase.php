<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authenticate($user = null)
    {
        $this->actingAs($user ?: factory('App\Models\User')->create());
    }
}
