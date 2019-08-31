<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\Core\Coloring\Colors;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Core\Jugglers\FrameJuggler;
use AlecRabbit\Spinner\Core\Jugglers\MessageJuggler;
use AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\typeOf;
use const AlecRabbit\ESC;

abstract class Spinner extends SpinnerCore
{
    /** @var Settings */
    protected $settings;
    /** @var bool */
    protected $inline = false;
    /** @var float */
    protected $interval;
    /** @var null|MessageJuggler */
    protected $messageJuggler;
    /** @var null|FrameJuggler */
    protected $frameJuggler;
    /** @var null|ProgressJuggler */
    protected $progressJuggler;
    /** @var string */
    protected $moveCursorBackSequence = '';
    /** @var string */
    protected $eraseBySpacesSequence = '';
    /** @var int */
    protected $previousErasingLength = 0;
    /** @var string */
    protected $spacer = Defaults::EMPTY_STRING;
    /** @var Colors */
    protected $coloring;
    /** @var null[]|JugglerInterface[] */
    protected $jugglers = [];
    /** @var string */
    protected $lastSpinnerString = '';

    /**
     * Spinner constructor.
     *
     * @param null|string|Settings $messageOrSettings
     * @param null|false|OutputInterface $output
     * @param null|int $color
     */
    public function __construct($messageOrSettings = null, $output = null, ?int $color = null)
    {
        $this->output = $this->refineOutput($output);
        $this->settings = $this->refineSettings($messageOrSettings);
        $this->interval = $this->settings->getInterval();
        $this->coloring = new Colors($this->settings->getStyles(), $color);
        $this->initJugglers();
        $this->jugglers = [
            &$this->frameJuggler,
            &$this->messageJuggler,
            &$this->progressJuggler,
        ];
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
                new FrameJuggler($this->settings, $this->coloring->getFrameStyles());
        }

        $message = $this->settings->getMessage();
        if (Defaults::EMPTY_STRING !== $message) {
            $this->setMessage($message, $this->settings->getMessageErasingLength());
        }
    }

    /**
     * @param null|string $message
     * @param null|int $erasingLength
     */
    protected function setMessage(?string $message, ?int $erasingLength = null): void
    {
        $this->settings->setMessage($message, $erasingLength);

        if ($this->messageJuggler instanceof MessageJuggler) {
            if (null === $message) {
                $this->messageJuggler = null;
            } else {
                $this->messageJuggler->setMessage($message, $erasingLength);
            }
        } else {
            $this->messageJuggler =
                null === $message ?
                    null :
                    new MessageJuggler($this->settings, $this->coloring->getMessageStyles());
        }
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        if ($this->output instanceof OutputInterface) {
            $this->erase();
            $this->output->write(Cursor::show());
            return self::EMPTY_STRING;
        }
        return $this->erase() . Cursor::show();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        $str = $this->eraseBySpacesSequence . $this->moveCursorBackSequence;
        if ($this->output instanceof OutputInterface) {
            $this->output->write($str);
            return self::EMPTY_STRING;
        }
        return $str;
    }

    /** {@inheritDoc} */
    public function getOutput(): ?OutputInterface
    {
        return $this->output;
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->inline = $inline;
        $this->spacer = $this->inline ? Defaults::ONE_SPACE_SYMBOL : Defaults::EMPTY_STRING;
        return $this;
    }

    public function interval(): float
    {
        return $this->interval;
    }

    /** {@inheritDoc} */
    public function message(?string $message = null, ?int $erasingLength = null): self
    {
        $this->setMessage($message, $erasingLength);
        return $this;
    }

    public function progress(?float $percent): self
    {
        $this->setProgress($percent);
        return $this;
    }

    /**
     * @param null|float $percent
     */
    protected function setProgress(?float $percent = null): void
    {
        $this->settings->setInitialPercent($percent);
        if ($this->progressJuggler instanceof ProgressJuggler) {
            if (null === $percent) {
                $this->progressJuggler = null;
            } else {
                $this->progressJuggler->setProgress($percent);
            }
        } else {
            $this->progressJuggler =
                null === $percent ? null : new ProgressJuggler($this->settings, $this->coloring->getProgressStyles());
        }
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        if (null === $percent) {
            $this->progressJuggler = null;
        } else {
            $this->setProgress($percent);
        }
        if ($this->output instanceof OutputInterface) {
            $this->output->write(Cursor::hide());
            $this->spin();
            return self::EMPTY_STRING;
        }
        return Cursor::hide() . $this->spin();
    }

    /** {@inheritDoc} */
    public function spin(): string
    {
        $this->lastSpinnerString = $this->preparedStr();
        return
            $this->last();
    }

    /** {@inheritDoc} */
    public function last(): string
    {
        if ($this->output instanceof OutputInterface) {
            $this->output->write($this->lastSpinnerString);
            return self::EMPTY_STRING;
        }
        return
            $this->lastSpinnerString;
    }

    protected function preparedStr(): string
    {
//        $start = hrtime(true);
        $str = '';
        $erasingLength = 0;
        $eraseTailBySpacesSequence = '';
        foreach ($this->jugglers as $juggler) {
            if ($juggler instanceof JugglerInterface) {
                $str .= $juggler->getStyledFrame();
                $erasingLength += $juggler->getFrameErasingLength();
            }
        }
        $erasingLength += $this->inline ? 1 : 0;
        $erasingLengthDelta = $this->previousErasingLength - $erasingLength;
        $this->previousErasingLength = $erasingLength;

        if ($erasingLengthDelta > 0) {
            $erasingLength += $erasingLengthDelta;
            $eraseTailBySpacesSequence = str_repeat(Defaults::ONE_SPACE_SYMBOL, $erasingLengthDelta);
        }
        $this->moveCursorBackSequence = ESC . "[{$erasingLength}D";
        $this->eraseBySpacesSequence = str_repeat(Defaults::ONE_SPACE_SYMBOL, $erasingLength);

        $str = $this->spacer . $str . $eraseTailBySpacesSequence . $this->moveCursorBackSequence;
//        dump(hrtime(true) - $start);
        return $str;
    }
}
