<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Exception\LoopException;

final readonly class LoopFactory implements ILoopFactory
{
    /**
     * @param class-string<ILoopCreator> $loopCreator
     */
    public function __construct(
        protected string $loopCreator,
    ) {
    }

    public function create(): ILoop
    {
        self::assertClass($this->loopCreator);

        return ($this->loopCreator)::create();
    }

    /**
     * @param class-string<ILoopCreator> $loopCreator
     * @throws LoopException
     */
    private static function assertClass(string $loopCreator): void
    {
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
