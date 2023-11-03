<?php

namespace Kyrill\PhpDiContainer;

class ReadDiFile
{
    /**
     * @throws \JsonException
     */
    public function processFile($path): object
 {
     $json = file_get_contents($path);
     $file = json_decode($json, false, 10000, JSON_THROW_ON_ERROR);
     return $file;
  }
}