<?php

declare(strict_types=1);

namespace Kyrill\PhpDiContainer;

use JsonException;
use Kyrill\PhpDiContainer\Exception\ClassDoesNotExistException;
use ReflectionClass;
use ReflectionException;

class Container
{
    private RegisterFileToContainer $registerFileToContainer;
    private array $registry = [];

    public function __construct()
    {
        $readFile = new ReadDiFile();
        $this->registerFileToContainer = new RegisterFileToContainer($readFile, $this);
    }

    /**
     * @param string $name
     * @return object
     * @throws ClassDoesNotExistException
     * @throws ReflectionException
     */
    public function resolve(string $name): object
    {
        $dependencies = $this->getDependencies($name);
        return $this->build($name, $dependencies);
    }

    /**
     * @throws JsonException
     */
    public function registerFile(string $path): void
    {
        $this->registerFileToContainer->registerFile($path);
    }

    public function register(string $name, array $dependencies): void
    {
        $this->registry[$name]['arguments'] = $dependencies;
    }

    public function registerClassFile(string $name, object $dependencies): void
    {
        $this->registry[$name] = $dependencies;
    }

    /**
     * @throws ReflectionException
     */
    private function getDependencies($name): array|object
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
     * @param array|object $dependencies
     * @return mixed
     * @throws ClassDoesNotExistException
     * @throws ReflectionException
     */
    private function build(string $name, array|object $dependencies): object
    {
        $classDependencies = [];
        if (isset($dependencies->class)) {
            $className = $dependencies->class;
        }
        if (isset($dependencies->arguments)) {
            $dependencies = $dependencies->arguments;
        }
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
        if (isset($className)) {
            if (isset($this->registry[$className])&& !class_exists($className)) {
                $name = $this->registry[$className]->class;
            } else {
                $name = $className;
            }
        }
        return new $name(...$classDependencies);
    }
}
