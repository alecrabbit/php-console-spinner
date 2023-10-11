<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Facade;
use Psr\Container\ContainerInterface;
use Traversable;

abstract class ContainerModifyingTestCase extends TestCase
{
    protected const GET_CONTAINER = 'getContainer';
    protected static ?ContainerInterface $container;

    protected static function setContainer(?ContainerInterface $container): void
    {
        Facade::setContainer($container);
    }

    protected function setUp(): void
    {
        self::$container = self::extractContainer();
        self::setContainer(self::modifyContainer(self::$container));
        parent::setUp();
    }

    protected static function extractContainer(): mixed
    {
        return self::callMethod(Facade::class, self::GET_CONTAINER);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        self::setContainer(self::$container);
    }
    protected static function modifyContainer(Container $container): ContainerInterface
    {
        $definitions = self::getPropertyValue('definitions', clone $container);

        return
            self::createContainer(
                self::modifyDefinitions(
                    $definitions
                )
            );
    }

    protected static function modifyDefinitions(\ArrayObject $definitions): \ArrayObject
    {
        // disable output
        $definitions
            ->offsetSet(
                IResourceStream::class,
                new class implements IResourceStream {
                    public function write(\Traversable $data): void
                    {
                        // do nothing
                    }
                }
            )
        ;

        // disable auto start
        $definitions
            ->offsetSet(
                ILoopSetup::class,
                new class implements ILoopSetup {
                    public function setup(ILoop $loop): void
                    {
                        // do nothing
                    }
                }
            )
        ;

        return $definitions;
    }

    protected static function createContainer(\ArrayObject $definitions): ContainerInterface
    {
        $registry =
            new class($definitions) implements IDefinitionRegistry {
                public function __construct(protected \Traversable $definitions)
                {
                }

                public function load(): Traversable
                {
                    return $this->definitions;
                }

                public function bind(string $typeId, callable|object|string $definition): void
                {
                    // do nothing
                }
            };

        return (new ContainerFactory($registry))->getContainer();
    }
}
