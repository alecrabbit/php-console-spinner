<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\Core\Adapters\EchoOutputAdapter;
use AlecRabbit\Spinner\Core\Contracts\Frames;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerOutputInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\typeOf;
use const AlecRabbit\ESC;

abstract class AbstractSpinner implements SpinnerInterface
{
    protected const INTERVAL = Defaults::DEFAULT_INTERVAL;
    protected const FRAMES = Frames::DIAMOND;
    protected const STYLES = StylesInterface::STYLING_DISABLED;

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
    /** @var int */
    protected $percentStrLen = 0;
    /** @var string */
    protected $percentSpacer;
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
    protected $frameErasingShift;
    /** @var Circular */
    protected $symbols;
    /** @var null|SpinnerOutputInterface */
    protected $output;
    /** @var int */
    protected $messageErasingLen;
    /** @var string */
    protected $spacer;
    /** @var Settings */
    protected $settings;
    /** @var int */
    protected $currentMessagePrefixLen;
    /** @var int */
    protected $currentMessageSuffixLen;
    /** @var int */
    protected $inlinePaddingStrLen;

    /**
     * AbstractSpinner constructor.
     *
     * @param null|string|Settings $messageOrSettings
     * @param null|false|SpinnerOutputInterface $output
     * @param mixed $color
     */
    public function __construct($messageOrSettings = null, $output = null, $color = null)
    {
        $this->output = $this->refineOutput($output);
        $this->settings = $this->refineSettings($messageOrSettings);
        $this->loadSettings($color);
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
//            return $settings;
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

    /**
     * @param mixed $color
     */
    protected function loadSettings($color): void
    {
        $this->interval = $this->settings->getInterval();
        $this->frameErasingShift = $this->settings->getErasingShift();
        $this->inlinePaddingStr = $this->settings->getInlinePaddingStr();
        $this->currentMessage = $this->settings->getMessage();
        $this->messageErasingLen = $this->settings->getMessageErasingLen();
        $this->currentMessagePrefix = $this->settings->getMessagePrefix();
        $this->currentMessageSuffix = $this->settings->getMessageSuffix();
        $this->spacer = $this->settings->getSpacer();
        $this->symbols = new Circular($this->settings->getFrames());

        try {
            $this->style = new Style($this->settings->getStyles(), $color);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(
                '[' . static::class . '] ' . $e->getMessage(),
                (int)$e->getCode(),
                $e
            );
        }
        $this->inlinePaddingStrLen = strlen($this->inlinePaddingStr); // TODO fix code duplicate?
        $this->currentMessagePrefixLen = strlen($this->currentMessagePrefix);
        $this->currentMessageSuffixLen = strlen($this->currentMessageSuffix);
        $this->messageStr = $this->prepareMessageStr();
        $this->updateProperties();
    }

    protected function prepareMessageStr(): string
    {
        return
            $this->spacer .
            $this->currentMessagePrefix .
            ucfirst($this->currentMessage) .
            $this->currentMessageSuffix;
    }

    protected function updateProperties(): void
    {
        $this->percentSpacer = $this->getPercentSpacer(); // TODO move to other location - optimize performance
        $strLen =
            $this->currentMessagePrefixLen +
            $this->messageErasingLen +
            $this->currentMessageSuffixLen +
            $this->percentStrLen +
            $this->inlinePaddingStrLen +
            $this->frameErasingShift;
        $this->moveBackSequenceStr = ESC . "[{$strLen}D";
        $this->eraseBySpacesStr = str_repeat(Defaults::ONE_SPACE_SYMBOL, $strLen);
    }

    /**
     * @return string
     */
    protected function getPercentSpacer(): string
    {
        if (strpos($this->messageStr, Defaults::DEFAULT_SUFFIX)) {
            return Defaults::ONE_SPACE_SYMBOL;
        }
        return Defaults::EMPTY;
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
        $this->inlinePaddingStr = $inline ? Defaults::ONE_SPACE_SYMBOL : Defaults::EMPTY;
        $this->inlinePaddingStrLen = strlen($this->inlinePaddingStr);
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
            $this->output->write($this->preparedStr());
            return '';
        }
        return
            $this->preparedStr();
    }

    /**
     * @param null|float $percent
     * @param null|string $message
     */
    protected function update(?float $percent, ?string $message): void
    {
        if ((null !== $percent) && 0 === ($percentVal = (int)($percent * 1000)) % 10) {
            $this->percentStr = $this->percentSpacer . ($percentVal / 10) . '% ';
            $this->percentStrLen = strlen($this->percentStr);
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
    protected function preparedStr(): string
    {
        return
            $this->inlinePaddingStr .
            $this->style->spinner((string)$this->symbols->value()) .
            $this->style->message(
                $this->message()
            ) .
            $this->style->percent(
                $this->percent()
            ) .
            $this->moveBackSequenceStr;
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        return $this->messageStr;
    }

    /**
     * @return string
     */
    protected function percent(): string
    {
        return $this->percentStr;
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

    /** {@inheritDoc} */
    public function getSettings(): Settings
    {
        throw new \RuntimeException(static::class . ': Call to unimplemented functionality ' . __METHOD__);
        return $this->settings;
    }
}
