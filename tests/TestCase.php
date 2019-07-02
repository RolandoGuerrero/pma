<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authenticate($user = null)
    {
        $user = $user ?: factory('App\Models\User')->create();
        
        $this->actingAs($user);
    
        return $user;
    }
}
