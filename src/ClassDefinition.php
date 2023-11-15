<?php
declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

class ClassDefinition
{
    private string $name;
    private array $arguments;
    private string $class;
    public function __construct(array $arguments, string $class)
    {
        $this->arguments = $arguments;
        $this->class = $class;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function isCached(): bool
    {
        return $this->cached;
    }
}