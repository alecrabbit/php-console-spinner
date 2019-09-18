<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Adapters\EchoOutputAdapter;
use AlecRabbit\Spinner\Core\Adapters\StdErrOutputAdapter;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\typeOf;

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
