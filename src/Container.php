<?php

declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

use Kyrill\PhpDiContainer\Exception\ClassDoesNotExistException;
use Kyrill\PhpDiContainer\Exception\ClassHasNotBeenRegistratedException;
use ReflectionClass;
use ReflectionException;

class Container
{
    private array $registry = [];

    private function getArguments($name): array
    {
        $dependencies = [];
        if (isset($this->registry[$name])) {
            return $this->registry[$name];
        }
        $reflection = new ReflectionClass($name);
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            return $dependencies;
        }
        foreach ($constructor->getParameters() as $param) {
            $dependencies[] = $param->getType()->getName();
        }
        return $dependencies;
    }
    /**
     * @param string $name
     * @return object
     * @throws ClassDoesNotExistException
     * @throws ReflectionException
     */
    public function resolve(string $name): object
    {
        $dependencies = $this->getArguments($name);
        return $this->build($name, $dependencies);
    }

    public function register(string $name, object $classObject): void
    {
        if ($classObject->getClass() === null && !class_exists($name) && !interface_exists($name) && !isset($this->registry[$name])) {
          throw new ClassHasNotBeenRegistratedException('Class name is not set in the json file or register method');
        }
        if ($classObject->getArguments() !== null) {
            $this->registry[$name]['arguments'] = $classObject->getArguments();
        }
        if ($classObject->getClass() !== null) {
            $this->registry[$name]['class'] = $classObject->getClass();
        }
    }

    /**
     * @param string $name
     * @param array $dependencies
     * @return mixed
     * @throws ClassDoesNotExistException
     */
    private function build(string $name, array $dependencies): object
    {
        [$className, $dependencies] = $this->assignDependenciesIfSet($dependencies, $name);

        $classDependencies = $this->resolveArguments($name, $dependencies);

        if (isset($className)) {
            $name = $className;
            if (isset($this->registry[$className]) && !class_exists($className)) {
                $name = $this->registry[$className]['class'];
            }
        }
        return new $name(...$classDependencies);
    }

    private function resolveArguments(string $name, array $dependencies): array
    {
        $classDependencies = [];

        foreach ($dependencies as $dependency) {
        if (!class_exists($dependency) && !interface_exists($dependency) && !isset($this->registry[$name])) {
            throw new ClassDoesNotExistException("Class $dependency does not exist");
        }
        if (!class_exists($dependency) && !interface_exists($dependency) && isset($this->registry[$name])) {
            $classDependencies[] = $dependency;
        } else {
            $classDependencies[] = $this->resolve($dependency);
        }
    }
        return $classDependencies;
    }
    private function assignDependenciesIfSet(array $dependencies, string $name): array
    {
        $className = null;
        $extractedDependencies = $dependencies;

        if ($dependencies['class'] !== null || $dependencies['arguments'] !== null) {
            if (isset($this->registry[$name])) {
                $className = $dependencies['class'] ?? null;
                $extractedDependencies = $dependencies['arguments'] ?? $dependencies;
            }
        }
        return [$className, $extractedDependencies];
    }
}
