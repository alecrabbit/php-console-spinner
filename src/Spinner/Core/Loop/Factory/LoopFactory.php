<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Exception\LoopException;

final readonly class LoopFactory implements ILoopFactory
{
    public function __construct(
        protected ILoopCreatorClassProvider $classProvider,
    ) {
    }

    public function create(): ILoop
    {
        $class = $this->classProvider->getCreatorClass();

        self::assertClass($class);

        /** @var class-string<ILoopCreator> $class */
        return (new $class)->create();
    }

    /**
     * @param null|class-string<ILoopCreator> $loopCreator
     * @throws LoopException
     */
    private static function assertClass(?string $loopCreator): void
    {
        if (null === $loopCreator) {
            throw new LoopException('Loop creator class is not provided.');
        }

        if (is_subclass_of($loopCreator, ILoopCreator::class) === false) {
            throw new LoopException(
                sprintf(
                    'Class "%s" must implement "%s" interface.',
                    $loopCreator,
                    ILoopCreator::class
                ),
            );
        }
    }
}
