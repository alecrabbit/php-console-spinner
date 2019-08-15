<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\Core\Adapters\EchoOutputAdapter;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use function AlecRabbit\typeOf;
use const AlecRabbit\ESC;

abstract class Spinner implements SpinnerInterface
{
    protected const INTERVAL = SettingsInterface::DEFAULT_INTERVAL;
    protected const SYMBOLS = Frames::DIAMOND;
    protected const STYLES = [];

    /** @var string */
    protected $messageStr;
    /** @var string */
    protected $currentMessage;
    /** @var string */
    protected $currentMessagePrefix;
    /** @var string */
    protected $currentMessageSuffix;
    /** @var string */
    protected $percentStr = '';
    /** @var string */
    protected $percentPrefix;
    /** @var string */
    protected $moveBackSequenceStr;
    /** @var string */
    protected $inlinePaddingStr;
    /** @var string */
    protected $eraseBySpacesStr;
    /** @var Style */
    protected $style;
    /** @var float */
    protected $interval;
    /** @var int */
    protected $erasingShift;
    /** @var Circular */
    protected $symbols;
    /** @var null|SpinnerOutputInterface */
    protected $output;
    /** @var int */
    protected $messageErasingLen;
    /** @var string */
    protected $spacer;
    /** @var SettingsInterface */
    private $settings;

    /**
     * AbstractSpinner constructor.
     *
     * @param mixed $settings
     * @param null|false|SpinnerOutputInterface $output
     * @param mixed $color
     */
    public function __construct($settings = null, $output = null, $color = null)
    {
        $this->output = $this->refineOutput($output);
        $this->settings = $this->refineSettings($settings);
        $this->interval = $this->settings->getInterval();
        $this->erasingShift = $this->settings->getErasingShift();
        $this->inlinePaddingStr = $this->settings->getInlinePaddingStr();
        $this->currentMessage = $this->settings->getMessage();
        $this->messageErasingLen = $this->settings->getMessageErasingLen();
        $this->currentMessagePrefix = $this->settings->getMessagePrefix();
        $this->currentMessageSuffix = $this->settings->getMessageSuffix();
        $this->spacer = $this->settings->getSpacer();
        $this->messageStr = $this->prepareMessageStr();
        $this->symbols = new Circular($this->settings->getSymbols());
        $this->updateProperties();

        try {
            $this->style = new Style($this->settings->getStyles(), $color);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(
                '[' . static::class . '] ' . $e->getMessage(),
                (int)$e->getCode(),
                $e
            );
        }
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
            $typeOrValue = true === $output ? 'true' : typeOf($output);
            throw new \InvalidArgumentException(
                'Incorrect $output param' .
                ' [null|false|SpinnerOutputInterface] expected'
                . ' "' . $typeOrValue . '" given.'
            );
        }
    }

    /**
     * @param mixed $settings
     * @return SettingsInterface
     */
    protected function refineSettings($settings): SettingsInterface
    {
        $this->assertSettings($settings);
        if (\is_string($settings)) {
            return
                $this->defaultSettings()->setMessage($settings);
        }
        return
            $settings ?? $this->defaultSettings();
    }

    /**
     * @param mixed $settings
     */
    protected function assertSettings($settings): void
    {
        if (null !== $settings && !\is_string($settings) && !$settings instanceof SettingsInterface) {
            throw new \InvalidArgumentException(
                'Instance of SettingsInterface or string expected ' . typeOf($settings) . ' given.'
            );
        }
    }

    /**
     * @return SettingsInterface
     */
    protected function defaultSettings(): SettingsInterface
    {
        return
            (new Settings())
                ->setInterval(static::INTERVAL)
                ->setSymbols(static::SYMBOLS)
                ->setStyles(static::STYLES);
    }

    protected function prepareMessageStr(): string
    {
        return $this->spacer . $this->currentMessagePrefix . ucfirst($this->currentMessage) . $this->currentMessageSuffix;
    }

    protected function updateProperties(): void
    {
        $this->percentPrefix = $this->getPercentPrefix(); // TODO move to other location - optimize performance
        // TODO optimize performance add some vars to store len of elements
        $strLen =
            strlen($this->currentMessagePrefix) +
            $this->messageErasingLen +
            strlen($this->currentMessageSuffix) +
            strlen($this->percent()) +
            strlen($this->inlinePaddingStr) +
            $this->erasingShift;
        $this->moveBackSequenceStr = ESC . "[{$strLen}D";
        $this->eraseBySpacesStr = str_repeat(SettingsInterface::ONE_SPACE_SYMBOL, $strLen);
    }

    /**
     * @return string
     */
    protected function getPercentPrefix(): string
    {
        if (strpos($this->messageStr, SettingsInterface::DEFAULT_SUFFIX)) {
            return SettingsInterface::ONE_SPACE_SYMBOL;
        }
        return SettingsInterface::EMPTY;
    }

    /**
     * @return string
     */
    protected function percent(): string
    {
        return $this->percentStr;
    }

    /** {@inheritDoc} */
    public function getOutput(): ?SpinnerOutputInterface
    {
        return $this->output;
    }

    public function interval(): float
    {
        return $this->interval;
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->inlinePaddingStr = $inline ? SettingsInterface::ONE_SPACE_SYMBOL : SettingsInterface::EMPTY;
        $this->updateProperties();
        return $this;
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        if ($this->output) {
            $this->output->write(Cursor::hide());
            $this->spin($percent);
            return '';
        }
        return Cursor::hide() . $this->spin($percent);
    }

    /** {@inheritDoc} */
    public function spin(?float $percent = null, ?string $message = null): string
    {
        $this->update($percent, $message);
        if ($this->output) {
            $this->output->write($this->prepareStr());
            return '';
        }
        return
            $this->prepareStr();
    }

    /**
     * @param null|float $percent
     * @param null|string $message
     */
    protected function update(?float $percent, ?string $message): void
    {
        if ((null !== $percent) && 0 === ($percentVal = (int)($percent * 1000)) % 10) {
            $this->percentStr = $this->percentPrefix . ($percentVal / 10) . '%';
        }
        if ((null !== $message) && $this->currentMessage !== $message) {
            $this->currentMessage = $message;
            $this->messageErasingLen = strlen($message);
            $this->messageStr = $this->prepareMessageStr();
        }
        if (null !== $percent || null !== $message) {
            $this->updateProperties();
        }
    }

    /**
     * @return string
     */
    protected function prepareStr(): string
    {
        $str = $this->inlinePaddingStr .
            $this->style->spinner((string)$this->symbols->value()) .
            $this->style->message(
                $this->message()
            ) .
            $this->style->percent(
                $this->percent()
            ) .
            $this->moveBackSequenceStr;
        return $str;
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        return $this->messageStr;
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        if ($this->output) {
            $this->erase();
            $this->output->write(Cursor::show());
            return '';
        }
        return $this->erase() . Cursor::show();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        $str = $this->eraseBySpacesStr . $this->moveBackSequenceStr;
        if ($this->output) {
            $this->output->write($str);
            return '';
        }
        return $str;
    }
}
