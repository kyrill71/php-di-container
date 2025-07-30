<?php

declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

use JsonException;

class JsonFileReader implements FileReaderInterface
{
    /**
     * @throws JsonException
     */
    public function read(string $path): array
    {
        $json = file_get_contents($path);
        return json_decode($json, true, 10000, JSON_THROW_ON_ERROR);
    }
}
