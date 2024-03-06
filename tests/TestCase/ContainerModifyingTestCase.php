<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Container\Reference;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Tests\TestCase\Stub\LoopSetupFactoryStub;
use AlecRabbit\Tests\TestCase\Stub\WritableStreamFactoryStub;
use ArrayObject;
use Traversable;

abstract class ContainerModifyingTestCase extends FacadeAwareTestCase
{
    protected static function setTestContainer(): void
    {
        self::setContainer(
            self::modifyContainer()
        );
    }

    protected static function modifyContainer(
        array $substitutes = []
    ): IContainer {
        return
            self::createContainer(
                self::modifyDefinitions(self::getDefinitions(), $substitutes)
            );
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
                    new Reference(WritableStreamFactoryStub::class),
                    IServiceDefinition::SINGLETON,
                ),
                // disable auto start
                new ServiceDefinition(
                    ILoopSetup::class,
                    new Reference(LoopSetupFactoryStub::class),
                ),
                LoopSetupFactoryStub::class => LoopSetupFactoryStub::class,
                WritableStreamFactoryStub::class => WritableStreamFactoryStub::class,
            ],
            $substitutes
        );
    }

    private static function getDefinitions(): ArrayObject
    {
        return new ArrayObject(
            iterator_to_array(
                DefinitionRegistry::getInstance()->load(),
            )
        );
    }
}
