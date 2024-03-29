<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Contract\ICreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Exception\InvalidArgument;

use function is_a;
use function sprintf;

final class LoopCreatorClassProvider implements ILoopCreatorClassProvider
{
    /** @var class-string<ILoopCreator>|null */
    private ?string $creatorClass = null;

    /**
     * @param class-string<ICreator>|null $creatorClass
     *
     * @throws InvalidArgument
     */
    public function __construct(?string $creatorClass)
    {
        self::assertClass($creatorClass);
        /** @var class-string<ILoopCreator>|null $creatorClass */
        $this->creatorClass = $creatorClass;
    }

    private static function assertClass(?string $creatorClass): void
    {
        if ($creatorClass === null) {
            return;
        }
        if (!is_a($creatorClass, ILoopCreator::class, true)) {
            throw new InvalidArgument(
                sprintf(
                    'Creator class must be of "%s" interface.',
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
