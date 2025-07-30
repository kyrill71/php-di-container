<?php

declare(strict_types=1);

namespace Tests\Fixtures;

class TestService
{
    public function getMessage(): string
    {
        return "Hello from TestService";
    }
}
