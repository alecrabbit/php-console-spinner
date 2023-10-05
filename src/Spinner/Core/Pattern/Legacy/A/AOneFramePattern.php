<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Legacy\A;

use AlecRabbit\Spinner\Contract\IFrame;

/** @psalm-suppress UnusedClass */
abstract class AOneFramePattern extends ALegacyPattern
{
    public function __construct(
        protected IFrame $frame,
    ) {
        parent::__construct();
    }
}
