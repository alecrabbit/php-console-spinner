<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use Traversable;

final class Template implements ITemplate
{
    public function getInterval(): IInterval
    {
        // TODO: Implement getInterval() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function getFrames(): Traversable
    {
        // TODO: Implement getFrames() method.
        throw new \RuntimeException('Not implemented.');
    }
}
