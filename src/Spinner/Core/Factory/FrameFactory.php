<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\IDeterminer;

final class FrameFactory implements IFrameFactory
{

    public function __construct(
        protected IDeterminer $determiner,
    ) {
    }

    public static function createEmpty(): IFrame
    {
        return new Frame('', 0);
    }

    public static function createSpace(): IFrame
    {
        return new Frame(' ', 1);
    }

    public function create(string $sequence, ?int $width = null): IFrame
    {
        return
            new Frame(
                $sequence,
                $width ?? $this->width($sequence)
            );
    }

    protected function width(string $sequence): int
    {
        return $this->determiner->getWidth($sequence);
    }
}
