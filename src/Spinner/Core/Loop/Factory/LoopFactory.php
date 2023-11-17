<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Exception\LoopException;

use function is_subclass_of;

final readonly class LoopFactory implements ILoopFactory
{
    public function __construct(
        protected ILoopCreatorClassProvider $classProvider,
    ) {
    }

    public function create(): ILoop
    {
        /** @var class-string<ILoopCreator> $class */
        $class = $this->classProvider->getCreatorClass();

        self::assertClass($class);

        return (new $class())->create();
    }

    /**
     * @param null|class-string<ILoopCreator> $loopCreator
     * @throws LoopException
     */
    private static function assertClass(?string $loopCreator): void
    {
        if ($loopCreator === null) {
            throw new LoopException('Loop creator class is not provided.');
        }

        if (is_subclass_of($loopCreator, ILoopCreator::class) === false) {
            throw new LoopException(
                sprintf(
                    'Class "%s" must be a subclass of "%s" interface.',
                    $loopCreator,
                    ILoopCreator::class
                ),
            );
        }
    }
}
