<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\TestCase;

use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use ArrayObject;
use Psr\Container\ContainerInterface;
use Traversable;

abstract class ContainerModifyingTestCase extends FacadeAwareTestCase
{
    private const DEFINITIONS = 'definitions';

    protected function setUp(): void
    {
        parent::setUp();
        $modifiedContainer = self::modifyContainer(clone self::getStoredContainer());
        self::setContainer($modifiedContainer);
    }

    protected static function modifyContainer(
        ContainerInterface $container,
        array $substitutes = []
    ): ContainerInterface {
        $definitions = self::getPropertyValue(self::DEFINITIONS, $container);

        return
            self::createContainer(
                self::modifyDefinitions($definitions, $substitutes)
            );
    }

    protected static function createContainer(ArrayObject $definitions): ContainerInterface
    {
        $registry =
            new class($definitions) implements IDefinitionRegistry {
                public function __construct(protected Traversable $definitions)
                {
                }

                public function load(): Traversable
                {
                    return $this->definitions;
                }

                public function register(string $id, callable|object|string $definition, ?int $options = 0): void
                {
                    // do nothing
                }
            };

        return (new ContainerFactory($registry))->create();
    }

    protected static function modifyDefinitions(ArrayObject $definitions, array $substitutes = []): ArrayObject
    {
        $substitutes =
            array_merge(
                [
                    // disable output
                    IWritableStream::class =>
                        new class implements IWritableStream {
                            public function write(Traversable $data): void
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
