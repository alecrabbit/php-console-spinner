<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Contract\StyleMode;
use ArrayObject;
use Traversable;

abstract class AMultiModeStylePattern extends AStylePattern
{
    protected const PATTERN = ['#000000'];

    public function __construct(
        ?int $interval = null,
        bool $reversed = false,
        protected StyleMode $styleMode = self::STYLE_MODE
    ) {
        parent::__construct($interval, $reversed);
    }

    public function getStyleMode(): StyleMode
    {
        return $this->styleMode;
    }

    protected function pattern(): Traversable
    {
        return
            new ArrayObject($this->extractPattern());
    }

    /**
     * @return array<int,string>
     */
    protected function extractPattern(): array
    {
        return self::PATTERN;
    }
}
