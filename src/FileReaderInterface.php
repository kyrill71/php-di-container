<?php
declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

interface FileReaderInterface
{
    public function read(string $path): array;
}