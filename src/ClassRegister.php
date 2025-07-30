<?php

declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

use Kyrill\PhpDiContainer\Exception\ClassHasNotBeenRegisteredException;

class ClassRegister
{
    /**
     * @throws ClassHasNotBeenRegisteredException
     */
    public function registerFile(string $path, FileReaderInterface $fileReader, Container $container): void
    {
        $content = $fileReader->read($path);
        $FileToDefinition = new ArrayToDefinition();
        $classDefinitions = $FileToDefinition->convert($content);

        foreach ($classDefinitions as $name => $classDefinition) {
            $container->register($name, $classDefinition);
        }
    }



}
