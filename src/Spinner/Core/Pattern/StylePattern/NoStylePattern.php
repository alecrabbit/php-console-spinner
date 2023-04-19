<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\StylePattern;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\A\AOneFramePattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStyleLegacyPattern;

/** @psalm-suppress UnusedClass */
final class NoStylePattern extends AOneFramePattern implements IStyleLegacyPattern
{
    protected const STYLE_MODE = OptionStyleMode::NONE;

    public function __construct()
    {
        parent::__construct(
            new Frame('%s', 0)
        );
    }

    public function getStyleMode(): OptionStyleMode
    {
        return self::STYLE_MODE;
    }
}
