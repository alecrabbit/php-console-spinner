<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\Core\Adapters\EchoOutputAdapter;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Jugglers\FrameJuggler;
use AlecRabbit\Spinner\Core\Jugglers\MessageJuggler;
use AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\typeOf;

class Spinner implements SpinnerInterface
{

    protected const INTERVAL = Defaults::DEFAULT_INTERVAL;
    protected const FRAMES = Frames::DIAMOND;
    protected const STYLES = StylesInterface::STYLING_DISABLED;

    protected const EMPTY_STRING = '';

    /** @var null|SpinnerOutputInterface */
    protected $output;
    /** @var Settings */
    protected $settings;
    /** @var bool */
    protected $inline;
    /** @var float */
    protected $interval;
    /** @var null|MessageJuggler */
    protected $messageJuggler;
    /** @var null|FrameJuggler */
    protected $frameJuggler;
    /** @var null|ProgressJuggler */
    protected $progressJuggler;

    /**
     * Spinner constructor.
     *
     * @param null|string|Settings $messageOrSettings
     * @param null|false|SpinnerOutputInterface $output
     * @param null|int $color
     */
    public function __construct($messageOrSettings = null, $output = null, ?int $color = null)
    {
        $this->output = $this->refineOutput($output);
        $this->settings = $this->refineSettings($messageOrSettings);
        $this->initJugglers();
    }

    /**
     * @param null|false|SpinnerOutputInterface $output
     * @return null|SpinnerOutputInterface
     */
    protected function refineOutput($output): ?SpinnerOutputInterface
    {
        $this->assertOutput($output);
        if (false === $output) {
            return null;
        }
        return $output ?? new EchoOutputAdapter();
    }

    /**
     * @param mixed $output
     */
    protected function assertOutput($output): void
    {
        if (null !== $output && false !== $output && !$output instanceof SpinnerOutputInterface) {
            $typeOrValue =
                true === $output ? 'true' : typeOf($output);
            throw new \InvalidArgumentException(
                'Incorrect parameter: ' .
                ' [null|false|' . SpinnerOutputInterface::class . '] expected'
                . ' "' . $typeOrValue . '" given.'
            );
        }
    }

    /**
     * @param null|string|Settings $settings
     * @return Settings
     */
    protected function refineSettings($settings): Settings
    {
        $this->assertSettings($settings);
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

    /**
     * @param mixed $settings
     */
    protected function assertSettings($settings): void
    {
        if (null !== $settings && !\is_string($settings) && !$settings instanceof Settings) {
            throw new \InvalidArgumentException(
                'Instance of [' . Settings::class . '] or string expected ' . typeOf($settings) . ' given.'
            );
        }
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

    protected function initJugglers(): void
    {
        $frames = $this->settings->getFrames();
        if (!empty($frames)) {
            $this->frameJuggler =
                new FrameJuggler(
                    $frames
                );
        }
        $message = $this->settings->getMessage();
        if (Defaults::EMPTY !== $message) {
            $this->messageJuggler =
                new MessageJuggler(
                    $message,
                    $this->settings->getMessageErasingLen()
                );
        }
//        $this->progressJuggler = new ProgressJuggler(0);
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        if ($this->output) {
            $this->erase();
            $this->output->write(Cursor::show());
            return self::EMPTY_STRING;
        }
        return $this->erase() . Cursor::show();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        $str = $this->eraseBySpacesStr . $this->moveBackSequenceStr;
        if ($this->output) {
            $this->output->write($str);
            return self::EMPTY_STRING;
        }
        return $str;
    }

    /** {@inheritDoc} */
    public function getOutput(): ?SpinnerOutputInterface
    {
        return $this->output;
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->inline = $inline;
        return $this;
    }

    public function interval(): float
    {
        return $this->interval;
    }

    public function message(string $message): void
    {
        $this->messageJuggler->setMessage($message);
    }

    public function progress(float $percent): void
    {
        $this->progressJuggler->setProgress($percent);
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        if ($this->output) {
            $this->output->write(Cursor::hide());
            $this->spin($percent);
            return self::EMPTY_STRING;
        }
        return Cursor::hide() . $this->spin($percent);
    }

    /** {@inheritDoc} */
    public function spin(?float $percent = null): string
    {
        $this->progressJuggler->setProgress($percent);
        if ($this->output) {
            $this->output->write($this->preparedStr());
            return self::EMPTY_STRING;
        }
        return
            $this->preparedStr();
    }

    protected function preparedStr(): string
    {
        return '';
    }
}