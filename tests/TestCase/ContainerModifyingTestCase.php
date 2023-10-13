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

abstract class ContainerModifyingTestCase extends FacadeAwareTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $modifiedContainer = self::modifyContainer(clone self::$container);
        self::setContainer($modifiedContainer);
    }

    protected static function modifyContainer(Container $container, array $substitutes = []): ContainerInterface
    {
        $definitions = self::getPropertyValue('definitions', $container);

        return
            self::createContainer(
                self::modifyDefinitions($definitions, $substitutes)
            );
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

    protected static function modifyDefinitions(\ArrayObject $definitions, array $substitutes = []): \ArrayObject
    {
        $substitutes =
            array_merge(
                [
                    // disable output
                    IResourceStream::class =>
                        new class implements IResourceStream {
                            public function write(\Traversable $data): void
                            {
                                // do nothing
                            }
                        },
                    // disable auto start
                    ILoopSetup::class =>
                        new class implements ILoopSetup {
                            public function setup(ILoop $loop): void
                            {
                                // do nothing
                            }
                        },
                ],
                $substitutes
            );

        foreach ($substitutes as $id => $substitute) {
            $definitions->offsetSet($id, $substitute);
        }

        return $definitions;
    }
}
