<?php
declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

class ArrayToDefinition
{
    public function convert(array $content): array
    {
        $classDefinitions = [];
        foreach ($content["services"] as $className => $classDefinition) {
            $classDefinitions[$className] = $this->arrayToClassDefinition($className, $classDefinition);
        }
        return $classDefinitions;
    }

    private function arrayToClassDefinition(string $className, array $classDefinition): ClassDefinition
    {
        $arguments = $classDefinition['arguments'] ?? [];
        $class = $classDefinition['class'] ?? $className;
        return new ClassDefinition($arguments, $class);
    }
}