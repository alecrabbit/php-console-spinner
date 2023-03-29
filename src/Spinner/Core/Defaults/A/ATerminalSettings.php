<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Helper\Asserter;
use ArrayObject;
use Traversable;

abstract class ATerminalSettings extends ADefaultsChild implements ITerminalSettings
{
    protected static Traversable $supportedColorModes;

    private static ?ITerminalSettings $objInstance = null; // private, singleton

    final protected function __construct(
        IDefaults $parent,
        protected OptionStyleMode $styleMode,
        protected int $width,
        protected OptionCursor $cursorOption,
    ) {
        parent::__construct($parent);
        static::$supportedColorModes = $this->defaultSupportedColorModes();
    }

    protected function defaultSupportedColorModes(): ArrayObject
    {
        return new ArrayObject(OptionStyleMode::cases());
    }

    final public static function getInstance(
        IDefaults $parent,
        OptionStyleMode $styleMode,
        int $width,
        OptionCursor $cursor,
    ): ITerminalSettings {
        if (null === self::$objInstance) {
            self::$objInstance =
                new class ($parent, $styleMode, $width, $cursor) extends ATerminalSettings {
                };
        }
        return self::$objInstance;
    }

    public function getStyleMode(): OptionStyleMode
    {
        return $this->styleMode;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function overrideColorMode(OptionStyleMode $colorMode): static
    {
        $this->styleMode = $colorMode;
        return $this;
    }

    public function overrideWidth(int $width): static
    {
        $this->width = $width;
        return $this;
    }

    public function isCursorDisabled(): bool
    {
        return $this->cursorOption === OptionCursor::HIDDEN;
    }

    public function overrideCursorOption(OptionCursor $cursor): static
    {
        $this->cursorOption = $cursor;
        return $this;
    }

    public function getSupportedColorModes(): Traversable
    {
        return static::$supportedColorModes;
    }

    /** @inheritdoc */
    public function overrideSupportedColorModes(Traversable $supportedColorModes): static
    {
        Asserter::assertColorModes($supportedColorModes);
        static::$supportedColorModes = $supportedColorModes;
        return $this;
    }

    public function getCursorOption(): OptionCursor
    {
        return $this->cursorOption;
    }
}
