<?php
declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

class ClassRegister
{

    public function registerFile(string $path, FileReaderInterface $fileReader, Container $container): void{
        $content = $fileReader->read($path);
        $FileToDefinition = new ArrayToDefinition();
        $classDefinitions = $FileToDefinition->convert($content);

        foreach ($classDefinitions as $name => $classDefinition) {
            $container->register($name, $classDefinition);
        }
    }



}