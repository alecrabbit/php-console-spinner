<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;

final class LoopSupportDetector implements ILoopSupportDetector
{
    public function __construct(
        protected ?string $creatorClass,
    ) {
    }

    public function isSupported(): bool
    {
        return is_subclass_of($this->creatorClass, ILoopCreator::class);
    }
//
//    protected static function assertClass(?string $class): void
//    {
//        if (null === $class) {
//            return;
//        }
//        if (!is_subclass_of($class, ILoopCreator::class, true)) {
//            throw new InvalidArgumentException(
//                sprintf(
//                    'Probe must be an instance of "%s" interface.',
//                    ILoopCreator::class
//                )
//            );
//        }
//    }
}
