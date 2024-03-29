<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use ArrayObject;
use Traversable;

abstract class ContainerModifyingTestCase extends FacadeAwareTestCase
{
    private const DEFINITIONS = 'definitions';

    protected static function setTestContainer(): void
    {
        self::setContainer(
            self::modifyContainer(
                self::getStoredContainer()
            )
        );
    }

    protected static function modifyContainer(
        IContainer $container,
        array $substitutes = []
    ): IContainer {
        $definitions = self::extractDefinitions($container);

        return
            self::createContainer(
                self::modifyDefinitions(clone $definitions, $substitutes)
            );
    }

    private static function extractDefinitions(IContainer $container): ArrayObject
    {
        return self::getPropertyValue(self::DEFINITIONS, $container);
    }

    private static function createContainer(ArrayObject $definitions): IContainer
    {
        $registry = self::createDefinitionRegistry($definitions);

        return (new ContainerFactory())->create($registry);
    }

    private static function createDefinitionRegistry(ArrayObject $definitions): IDefinitionRegistry
    {
        return new class($definitions) implements IDefinitionRegistry {
            public function __construct(protected Traversable $definitions)
            {
            }

            public function load(): Traversable
            {
                return $this->definitions;
            }

            public function bind(IServiceDefinition ...$serviceDefinitions): void
            {
                // do nothing
            }
        };
    }

    private static function modifyDefinitions(ArrayObject $definitions, array $substitutes = []): ArrayObject
    {
        $substitutes = self::mergeSubstitutes($substitutes);

        foreach ($substitutes as $id => $substitute) {
            if ($substitute instanceof IServiceDefinition) {
                $definitions->offsetSet($substitute->getId(), $substitute);
                continue;
            }
            $definitions->offsetSet($id, new ServiceDefinition($id, $substitute));
        }

        return $definitions;
    }

    private static function mergeSubstitutes(array $substitutes): array
    {
        return array_merge(
            [
                // disable output
                new ServiceDefinition(
                    IWritableStream::class,
                    new class() implements IWritableStream {
                        public function write(Traversable $data): void
                        {
                            // do nothing
                        }
                    },
                    IServiceDefinition::SINGLETON,
                ),
                // disable auto start
                new ServiceDefinition(
                    ILoopSetup::class,
                    new class() implements ILoopSetup {
                        public function setup(ILoop $loop): void
                        {
                            // do nothing
                        }
                    },
                ),
            ],
            $substitutes
        );
    }
}
