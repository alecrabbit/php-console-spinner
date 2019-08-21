<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Settings;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Contracts\SettingsInterface;

class Settings implements SettingsInterface
{
    protected const INTERVAL = 'interval';
    protected const ERASING_SHIFT = 'erasingShift';
    protected const MESSAGE = 'message';
    protected const MESSAGE_ERASING_LENGTH = 'messageErasingLen';
    protected const MESSAGE_PREFIX = 'messagePrefix';
    protected const MESSAGE_SUFFIX = 'messageSuffix';

    /** @var Property[] */
    protected $properties =
        [
            self::INTERVAL => Defaults::DEFAULT_INTERVAL,
            self::ERASING_SHIFT => null,
            self::MESSAGE => null,
            self::MESSAGE_ERASING_LENGTH => null,
        ];

    public function __construct()
    {
        $this->initialize();
    }

    private function initialize(): void
    {
        foreach ($this->properties as $name => $value) {
            $this->properties[$name] = new Property($value);
        }
    }

    public function getInterval(): float
    {
        return
            $this->properties[self::INTERVAL]->getValue();
    }

    public function setInterval(float $interval): SettingsInterface
    {
        $this->properties[self::INTERVAL]->setValue($interval);
        return $this;
    }

    public function getErasingShift(): int
    {
        return
            $this->properties[self::ERASING_SHIFT]->getValue();
    }

    public function getMessage(): string
    {
        return
            $this->properties[self::MESSAGE]->getValue();
    }

    public function setMessage(string $message, int $erasingLength = null): SettingsInterface
    {
        $this->properties[self::MESSAGE]->setValue($message);
        $this->properties[self::MESSAGE_ERASING_LENGTH]->setValue($erasingLength);
        return $this;
    }

    public function getMessagePrefix(): string
    {
        return
            $this->properties[self::MESSAGE_PREFIX]->getValue();
    }

    public function setMessagePrefix(string $prefix): SettingsInterface
    {
        $this->properties[self::MESSAGE_PREFIX]->setValue($prefix);
        return $this;
    }

    public function getMessageSuffix(): string
    {
        return
            $this->properties[self::MESSAGE_SUFFIX]->getValue();
    }

    public function setMessageSuffix(string $suffix): SettingsInterface
    {
        $this->properties[self::MESSAGE_SUFFIX]->setValue($suffix);
        return $this;
    }

    public function getInlinePaddingStr(): string
    {
        // TODO: Implement getInlinePaddingStr() method.
    }

    public function setInlinePaddingStr(string $inlinePaddingStr): SettingsInterface
    {
        // TODO: Implement setInlinePaddingStr() method.
        return $this;
    }

    public function getFrames(): array
    {
        // TODO: Implement getFrames() method.
    }

    public function setFrames(array $symbols): SettingsInterface
    {
        // TODO: Implement setFrames() method.
        return $this;
    }

    public function getStyles(): array
    {
        // TODO: Implement getStyles() method.
    }

    public function setStyles(array $styles): SettingsInterface
    {
        // TODO: Implement setStyles() method.
        return $this;
    }

    public function getMessageErasingLen(): int
    {
        // TODO: Implement getMessageErasingLen() method.
    }

    public function getSpacer(): string
    {
        // TODO: Implement getSpacer() method.
    }

    public function setSpacer(string $spacer): SettingsInterface
    {
        // TODO: Implement setSpacer() method.
        return $this;
    }

    public function merge(SettingsInterface $settings): SettingsInterface
    {
        // TODO: Implement merge() method.
        return $this;
    }

}