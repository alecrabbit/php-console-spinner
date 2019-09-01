<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\Core\Coloring\Colors;
use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
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
    protected $moveCursorBackSequence = self::EMPTY_STRING;
    /** @var string */
    protected $eraseBySpacesSequence = self::EMPTY_STRING;
    /** @var int */
    protected $previousErasingLength = 0;
    /** @var Colors */
    protected $coloring;
    /** @var null[]|JugglerInterface[] */
    protected $jugglers = [];
    /** @var string */
    protected $lastSpinnerString = self::EMPTY_STRING;
    /** @var string */
    protected $inlinePaddingStr = self::EMPTY_STRING;

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
        $this->disabled = !$this->settings->isEnabled();
        $this->inlinePaddingStr = $this->settings->getInlinePaddingStr();
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
        if (self::EMPTY_STRING !== $message) {
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
        if ($this->disabled) {
            return self::EMPTY_STRING;
        }
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
        if ($this->disabled) {
            return self::EMPTY_STRING;
        }
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
        $this->inlinePaddingStr = $this->inline ? Defaults::ONE_SPACE_SYMBOL : self::EMPTY_STRING;
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
        if ($this->disabled) {
            return self::EMPTY_STRING;
        }
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
        if ($this->disabled) {
            return self::EMPTY_STRING;
        }
        $this->lastSpinnerString = $this->prepareLastSpinnerString();
        return
            $this->last();
    }

    protected function prepareLastSpinnerString(): string
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
        $erasingLength += $this->inline ? strlen($this->inlinePaddingStr) : 0;
        $erasingLengthDelta = $this->previousErasingLength - $erasingLength;
        $this->previousErasingLength = $erasingLength;

        if ($erasingLengthDelta > 0) {
            $erasingLength += $erasingLengthDelta;
            $eraseTailBySpacesSequence = str_repeat(Defaults::ONE_SPACE_SYMBOL, $erasingLengthDelta);
        }
        $this->moveCursorBackSequence = ESC . "[{$erasingLength}D";
        $this->eraseBySpacesSequence = str_repeat(Defaults::ONE_SPACE_SYMBOL, $erasingLength);

        $str = $this->inlinePaddingStr . $str . $eraseTailBySpacesSequence . $this->moveCursorBackSequence;
//        dump(hrtime(true) - $start);
        return $str;
    }

    /** {@inheritDoc} */
    public function last(): string
    {
        if ($this->disabled) {
            return self::EMPTY_STRING;
        }
        if ($this->output instanceof OutputInterface) {
            $this->output->write($this->lastSpinnerString);
            return self::EMPTY_STRING;
        }
        return
            $this->lastSpinnerString;
    }
}
