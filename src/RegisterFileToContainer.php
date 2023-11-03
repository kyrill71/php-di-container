<?php

namespace Kyrill\PhpDiContainer;

class RegisterFileToContainer
{
    private ReadDiFile $readDiFile;
    private Container $container;

    public function __construct(ReadDiFile $readDiFile, Container $container)
    {
        $this->readDiFile = $readDiFile;
        $this->container = $container;
    }

    /**
     * @throws \JsonException
     */
    public function registerFile(string $filepath): void
    {
      $fileContent = $this->readDiFile->processFile($filepath);

        foreach($fileContent->services as $index => $item) {
            $this->container->registerClassFile($index, $item);
        }
    }
}