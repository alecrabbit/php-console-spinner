<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\Cursor;
use AlecRabbit\Spinner\Contract\StyleMode;
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
        protected StyleMode $colorMode,
        protected int $width,
        protected Cursor $cursor,
    ) {
        parent::__construct($parent);
        static::$supportedColorModes = $this->defaultSupportedColorModes();
    }

    protected function defaultSupportedColorModes(): ArrayObject
    {
        return new ArrayObject(StyleMode::cases());
    }

    final public static function getInstance(
        IDefaults $parent,
        StyleMode $colorMode,
        int $width,
        Cursor $cursor,
    ): ITerminalSettings {
        if (null === self::$objInstance) {
            self::$objInstance =
                new class ($parent, $colorMode, $width, $cursor) extends ATerminalSettings {
                };
        }
        return self::$objInstance;
    }

    public function getStyleMode(): StyleMode
    {
        return $this->colorMode;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function overrideColorMode(StyleMode $colorMode): static
    {
        $this->colorMode = $colorMode;
        return $this;
    }

    public function overrideWidth(int $width): static
    {
        $this->width = $width;
        return $this;
    }

    public function isCursorDisabled(): bool
    {
        return $this->cursor === Cursor::DISABLED;
    }

    public function overrideCursor(Cursor $cursor): static
    {
        $this->cursor = $cursor;
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
}
