<?php

declare(strict_types=1);

namespace Tests\Fixtures;

class TestDependency
{
    public function __construct(public TestService $testService)
    {
    }

}
