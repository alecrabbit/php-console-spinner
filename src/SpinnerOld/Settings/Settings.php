<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld\Settings;

use AlecRabbit\SpinnerOld\Core\Sentinel;
use AlecRabbit\SpinnerOld\Settings\Contracts\Defaults;
use AlecRabbit\SpinnerOld\Settings\Contracts\S;
use AlecRabbit\SpinnerOld\Settings\Contracts\SettingsInterface;

class Settings implements SettingsInterface
{
    /** @var Property[] */
    protected $properties;

    public function __construct()
    {
        $this->properties = $this->initialize();
    }

    /**
     * @return Property[]
     */
    private function initialize(): array
    {
        $properties = [];
        foreach (Defaults::DEFAULT_SETTINGS as $name => $value) {
            $properties[$name] = new Property($value);
        }
        return $properties;
    }

    /** {@inheritDoc} */
    public function getInterval(): float
    {
        return
            $this->properties[S::INTERVAL]->getValue();
    }

    /** {@inheritDoc} */
    public function setInterval(float $interval): self
    {
        $this->properties[S::INTERVAL]->setValue($interval);
        return $this;
    }

    /** {@inheritDoc} */
    public function isHideCursor(): bool
    {
        return
            $this->properties[S::HIDE_CURSOR]->getValue();
    }

    /** {@inheritDoc} */
    public function setHideCursor($value = true): self
    {
        $this->properties[S::HIDE_CURSOR]->setValue($value);
        return $this;
    }

    /** {@inheritDoc} */
    public function isEnabled(): bool
    {
        return
            $this->properties[S::ENABLED]->getValue();
    }

    /** {@inheritDoc} */
    public function setEnabled(bool $enabled = true): self
    {
        $this->properties[S::ENABLED]->setValue($enabled);
        return $this;
    }

    /** {@inheritDoc} */
    public function getMessage(): ?string
    {
        return
            $this->properties[S::MESSAGE]->getValue();
    }

    /** {@inheritDoc} */
    public function setMessage(?string $message): self
    {
        $this->properties[S::MESSAGE]->setValue($message);
        return $this;
    }

    /** {@inheritDoc} */
    public function setMessageSuffix(string $suffix): self
    {
        $this->properties[S::MESSAGE_SUFFIX]->setValue($suffix);
        return $this;
    }

    /** {@inheritDoc} */
    public function getMessageSuffix(): string
    {
        return
            $this->properties[S::MESSAGE_SUFFIX]->getValue();
    }

    /** {@inheritDoc} */
    public function getInlineSpacer(): string
    {
        return
            $this->properties[S::INLINE_SPACER]->getValue();
    }

    /** {@inheritDoc} */
    public function setInlineSpacer(string $inlineSpacer): self
    {
        $this->properties[S::INLINE_SPACER]->setValue($inlineSpacer);
        return $this;
    }

    /** {@inheritDoc} */
    public function getFrames(): array
    {
        return
            $this->properties[S::FRAMES]->getValue();
    }

    /** {@inheritDoc} */
    public function setFrames(array $frames): self
    {
        Sentinel::assertFrames($frames);
        $this->properties[S::FRAMES]->setValue($frames);
        return $this;
    }

    /** {@inheritDoc} */
    public function getStyles(): array
    {
        return
            $this->properties[S::STYLES]->getValue();
    }

    /** {@inheritDoc} */
    public function setStyles(array $styles): self
    {
        $this->properties[S::STYLES]->setValue($styles);
        return $this;
    }

    /** {@inheritDoc} */
    public function getSpacer(): string
    {
        return
            $this->properties[S::SPACER]->getValue();
    }

    /** {@inheritDoc} */
    public function setSpacer(string $spacer): self
    {
        $this->properties[S::SPACER]->setValue($spacer);
        return $this;
    }

    /** {@inheritDoc} */
    public function merge(self $settings): self
    {
        $keys = array_keys($this->properties);
        foreach ($keys as $key) {
            if ($settings->properties[$key]->isNotDefault()) {
                $this->properties[$key] = $settings->properties[$key];
            }
        }
        return $this;
    }

    /** {@inheritDoc} */
    public function getInitialPercent(): ?float
    {
        return $this->properties[S::INITIAL_PERCENT]->getValue();
    }

    /** {@inheritDoc} */
    public function setInitialPercent(?float $percent): self
    {
        $this->properties[S::INITIAL_PERCENT]->setValue($percent);
        return $this;
    }

    /** {@inheritDoc} */
    public function getJugglersOrder(): array
    {
        return $this->properties[S::JUGGLERS_ORDER]->getValue();
    }

    /** {@inheritDoc} */
    public function setJugglersOrder(array $order): self
    {
        $order = array_unique($order);
        Sentinel::assertJugglersOrder($order);
        $this->properties[S::JUGGLERS_ORDER]->setValue($order);
        return $this;
    }
}
