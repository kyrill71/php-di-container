<?php

declare(strict_types=1);

namespace Tests;

use Kyrill\PhpDiContainer\ClassDefinition;
use Kyrill\PhpDiContainer\ClassRegister;
use Kyrill\PhpDiContainer\Container;
use Kyrill\PhpDiContainer\Exception\ClassDoesNotExistException;
use Kyrill\PhpDiContainer\Exception\ClassHasNotBeenRegisteredException;
use Kyrill\PhpDiContainer\JsonFileReader;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Tests\Fixtures\TestDependency;
use Tests\Fixtures\TestService;

class ContainerTest extends TestCase
{
    /**
     * @throws ReflectionException
     * @throws ClassHasNotBeenRegisteredException
     * @throws ClassDoesNotExistException
     */
    public function testCanResolveRegisteredClass(): void
    {
        $container = new Container();
        $container->register('TestService', new ClassDefinition([], TestService::class, false));

        $service = $container->resolve(TestService::class);

        $this->assertInstanceOf(TestService::class, $service);
        $this->assertEquals("Hello from TestService", $service->getMessage());
    }

    /**
     * @throws ReflectionException
     * @throws ClassDoesNotExistException
     */
    public function testCanAutoResolveClass(): void
    {
        $container = new Container();

        $dependencyTestClass = $container->resolve(TestDependency::class);

        $this->assertInstanceOf(TestDependency::class, $dependencyTestClass);
        $this->assertEquals("Hello from TestService", $dependencyTestClass->testService->getMessage());

    }

    /**
     * @throws ClassHasNotBeenRegisteredException
     */
    public function testCanResolveJsonRegisteredClass(): void
    {
        $container = new Container();
        $classRegister = new ClassRegister();
        $classRegister->registerFile('tests/Fixtures/di.json', new JsonFileReader(), $container);

        $service = $container->resolve('Tests\\Fixtures\\TestService2');


        $this->assertInstanceOf(TestService::class, $service);
        $this->assertEquals("Hello from TestService", $service->getMessage());

    }

}
