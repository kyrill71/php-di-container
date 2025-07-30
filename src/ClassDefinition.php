<?php

declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

class ClassDefinition
{

    public function __construct(private array $arguments, private string $class, private bool $isSingleton = false)
    {
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getClass(): string
    {
        return $this->class;
    }
    public function isSingleton(): bool
    {
        return $this->isSingleton;
    }
}
