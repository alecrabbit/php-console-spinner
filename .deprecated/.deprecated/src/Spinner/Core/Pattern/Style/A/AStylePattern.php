<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use ArrayObject;
use Traversable;

abstract class AStylePattern extends AReversiblePattern implements IStylePattern
{
    /** @var OptionStyleMode */
    protected const STYLE_MODE = OptionStyleMode::ANSI8;

    /** @var array<int, string> */
    protected const PATTERN = ['#c0c0c0'];

    public function __construct(
        ?int $interval = null,
        bool $reversed = false,
        protected OptionStyleMode $styleMode = self::STYLE_MODE
    ) {
        parent::__construct($interval, $reversed);
    }

    public function getStyleMode(): OptionStyleMode
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
        return static::PATTERN;
    }
}