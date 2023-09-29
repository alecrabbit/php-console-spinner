<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Pattern\Legacy\A\AOneFramePattern;
use AlecRabbit\Spinner\Core\Pattern\Legacy\Contract\ICharLegacyPattern;
use Traversable;

/** @psalm-suppress UnusedClass */
final class NoCharPattern extends AOneFramePattern implements ICharLegacyPattern
{
    public function __construct()
    {
        parent::__construct(
            frame: new CharFrame('', 0)
        );
    }


    public function getEntries(): Traversable
    {
        yield from [
            $this->frame,
        ];
    }
}
