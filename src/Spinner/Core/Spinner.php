<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\Core\Adapters\EchoOutputAdapter;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Core\Jugglers\FrameJuggler;
use AlecRabbit\Spinner\Core\Jugglers\MessageJuggler;
use AlecRabbit\Spinner\Core\Jugglers\ProgressJuggler;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use AlecRabbit\Tests\Spinner\Helper;
use function AlecRabbit\typeOf;
use const AlecRabbit\ESC;

abstract class Spinner implements SpinnerInterface
{
    protected const EMPTY_STRING = Defaults::EMPTY_STRING;

    protected const INTERVAL = Defaults::DEFAULT_INTERVAL;
    protected const FRAMES = Frames::BASE;
    protected const STYLES = StylesInterface::STYLING_DISABLED;

    /** @var null|SpinnerOutputInterface */
    protected $output;
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
    /** @var null|int */
    protected $previousErasingLength = 0;
    /** @var string */
    protected $spacer = Defaults::EMPTY_STRING;
    /** @var Style */
    protected $style;
    /** @var null[]|JugglerInterface[] */
    protected $jugglers = [];

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
        $this->interval = $this->settings->getInterval();
        $this->initJugglers();
        try {
            $this->style = new Style($this->settings->getStyles(), $color);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(
                '[' . static::class . '] ' . $e->getMessage(),
                (int)$e->getCode(),
                $e
            );
        }
        $this->jugglers = [
            &$this->frameJuggler,
            &$this->messageJuggler,
            &$this->progressJuggler,
        ];
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
                '[null|false|' . SpinnerOutputInterface::class . '] expected'
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
        if (Defaults::EMPTY_STRING !== $message) {
            $this->setMessage($message, $this->settings->getMessageErasingLen());
        }
    }

    /**
     * @param null|string $message
     * @param null|int $erasingLength
     */
    protected function setMessage(?string $message, ?int $erasingLength = null): void
    {
        if ($this->messageJuggler instanceof MessageJuggler) {
            if (null === $message) {
                $this->messageJuggler = null;
            } else {
                $this->messageJuggler->setMessage($message, $erasingLength);
            }
        } else {
            $this->messageJuggler =
                null === $message ? null : new MessageJuggler($message, $erasingLength);
        }
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        if ($this->output instanceof SpinnerOutputInterface) {
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
        if ($this->output instanceof SpinnerOutputInterface) {
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
//        dump($this->jugglers);

        return $this;
    }

    /**
     * @param null|float $percent
     */
    protected function setProgress(?float $percent = null): void
    {
        if ($this->progressJuggler instanceof ProgressJuggler) {
            if (null === $percent) {
                $this->progressJuggler = null;
            } else {
                $this->progressJuggler->setProgress($percent);
            }
        } else {
            $this->progressJuggler =
                null === $percent ? null : new ProgressJuggler($percent);
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
        if ($this->output instanceof SpinnerOutputInterface) {
            $this->output->write(Cursor::hide());
            $this->spin();
            return self::EMPTY_STRING;
        }
        return Cursor::hide() . $this->spin();
    }

    /** {@inheritDoc} */
    public function spin(): string
    {
        if ($this->output instanceof SpinnerOutputInterface) {
            $this->output->write($this->preparedStr());
            return self::EMPTY_STRING;
        }
        return
            $this->preparedStr();
    }

    protected function preparedStr(): string
    {
        // TODO optimize for performance
        $str = '';
        $erasingLength = 0;
        $eraseTailBySpacesSequence = '';
        if ($this->frameJuggler instanceof FrameJuggler) {
            $str .= $this->style->spinner($this->frameJuggler->getFrame());
            $erasingLength += $this->frameJuggler->getFrameErasingLength();
        }
        if ($this->messageJuggler instanceof MessageJuggler) {
            $str .= $this->style->message($this->messageJuggler->getFrame());
            $erasingLength += $this->messageJuggler->getFrameErasingLength();
        }
        if ($this->progressJuggler instanceof ProgressJuggler) {
            $str .= $this->style->percent($this->progressJuggler->getFrame());
            $erasingLength += $this->progressJuggler->getFrameErasingLength();
        }
        $erasingLength += $this->inline ? 1 : 0;
        $erasingLengthDelta = $this->previousErasingLength - $erasingLength;
////        dump($erasingLengthDelta );
        dump(
            sprintf('D:%s P:%s E:%s',
                $erasingLengthDelta,
                $this->previousErasingLength,
                $erasingLength
            )
        );
        if ($erasingLengthDelta > 0) {

            $erasingLength += $erasingLengthDelta;
            $eraseTailBySpacesSequence = str_repeat(Defaults::ONE_SPACE_SYMBOL, $erasingLengthDelta);
        }
        $this->moveCursorBackSequence = ESC . "[{$erasingLength}D";
        $this->eraseBySpacesSequence = str_repeat(Defaults::ONE_SPACE_SYMBOL, $erasingLength);

        $this->previousErasingLength = $erasingLength;
        dump(
            sprintf(
                'D:%s P2:%s E:%s',
                $erasingLengthDelta,
                $this->previousErasingLength,
                $erasingLength
            )
        );

//        return Helper::stripEscape($this->spacer . $str . $eraseTailBySpacesSequence . $this->moveCursorBackSequence) . PHP_EOL;
        return $this->spacer . $str . $eraseTailBySpacesSequence . $this->moveCursorBackSequence;
    }
}
