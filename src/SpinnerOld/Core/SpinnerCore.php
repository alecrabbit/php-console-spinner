<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld\Core;

use AlecRabbit\SpinnerOld\Core\Adapters\StdErrOutputAdapter;
use AlecRabbit\SpinnerOld\Core\Contracts\Frames;
use AlecRabbit\SpinnerOld\Core\Contracts\SpinnerInterface;
use AlecRabbit\SpinnerOld\Core\Contracts\OutputInterface;
use AlecRabbit\SpinnerOld\Core\Contracts\Styles;
use AlecRabbit\SpinnerOld\Settings\Contracts\Defaults;
use AlecRabbit\SpinnerOld\Settings\Settings;

abstract class SpinnerCore implements SpinnerInterface
{
    protected const EMPTY_STRING = Defaults::EMPTY_STRING;

    protected const INTERVAL = Defaults::DEFAULT_INTERVAL;
    protected const FRAMES = Frames::BASE;
    protected const STYLES = Styles::STYLING_DISABLED;

    /** @var null|OutputInterface */
    protected $output;
    /** @var bool */
    protected $enabled;
    /** @var float */
    protected $interval;

    /**
     * @param null|false|OutputInterface $output
     * @return null|OutputInterface
     */
    protected function refineOutput($output): ?OutputInterface
    {
        Sentinel::assertOutput($output);
        if (false === $output) {
            return null;
        }
        return $output ?? new StdErrOutputAdapter();
    }

    /** {@inheritDoc} */
    public function disable(): SpinnerInterface
    {
        $this->enabled = false;
        return $this;
    }

    /** {@inheritDoc} */
    public function enable(): SpinnerInterface
    {
        $this->enabled = true;
        return $this;
    }

    /** {@inheritDoc} */
    public function isActive(): bool
    {
        return $this->enabled;
    }

    /**
     * @param null|string|Settings $settings
     * @return Settings
     */
    protected function refineSettings($settings): Settings
    {
        Sentinel::assertSettings($settings);
        if (\is_string($settings)) {
            return
                $this->defaultSettings()->setMessage($settings);
        }
        if ($settings instanceof Settings) {
            return $this->defaultSettings()->merge($settings);
        }
        return
            $this->defaultSettings();
    }

    /** {@inheritDoc} */
    public function interval(): float
    {
        return $this->interval;
    }

    /**
     * @return Settings
     */
    protected function defaultSettings(): Settings
    {
        return
            (new Settings())
                ->setInterval(static::INTERVAL)
                ->setFrames(static::FRAMES)
                ->setStyles(static::STYLES);
    }
}
