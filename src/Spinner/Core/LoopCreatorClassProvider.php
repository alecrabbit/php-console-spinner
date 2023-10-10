<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class LoopCreatorClassProvider implements ILoopCreatorClassProvider
{
    /** @var class-string<ILoopCreator>|null */
    protected ?string $creatorClass = null;

    /**
     * @param class-string<ILoopCreator>|null $creatorClass
     * @throws InvalidArgumentException
     */
    public function __construct(?string $creatorClass)
    {
        self::assertClass($creatorClass);
        $this->creatorClass = $creatorClass;
    }

    private static function assertClass(?string $creatorClass): void
    {
        if ($creatorClass === null) {
            return;
        }
        if (!is_a($creatorClass, ILoopCreator::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Creator class must be an instance of "%s" interface.',
                    ILoopCreator::class
                )
            );
        }
    }

    public function getCreatorClass(): ?string
    {
        return $this->creatorClass;
    }
}
