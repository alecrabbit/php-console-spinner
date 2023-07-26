<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\A\AOneFramePattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

/** @psalm-suppress UnusedClass */
final class NoStylePattern extends AOneFramePattern implements IStylePattern
{
    public function __construct()
    {
        parent::__construct(
            frame: new StyleFrame('%s', 0)
        );
    }

    public function getStyleMode(): StylingMethodOption
    {
        return StylingMethodOption::NONE;
    }

    public function getEntries(StylingMethodOption $styleMode = StylingMethodOption::ANSI8): Traversable
    {
        yield from [
            $this->frame,
        ];
    }
}
