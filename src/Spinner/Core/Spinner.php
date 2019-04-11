<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Pretty;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\Control\Cursor;
use AlecRabbit\Spinner\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Contracts\SpinnerStyles;
use function AlecRabbit\typeOf;

class Spinner implements SpinnerInterface
{
    protected const ERASING_SHIFT = 1;
    protected const INTERVAL = 0.1;
    protected const SYMBOLS = [''];
    protected const
        STYLES =
        [
            Styling::COLOR256_SPINNER_STYLES => SpinnerStyles::DISABLED,
            Styling::COLOR_SPINNER_STYLES => SpinnerStyles::DISABLED,
        ];

    /** @var string */
    protected $messageStr;
    /** @var string */
    protected $percentStr = '';
    /** @var string */
    protected $percentPrefix;
    /** @var string */
    protected $moveBackSequenceStr;
    /** @var string */
    protected $paddingStr;
    /** @var string */
    protected $eraseBySpacesStr;
    /** @var Styling */
    protected $styled;

    /**
     * AbstractSpinner constructor.
     * @param mixed $settings
     */
    public function __construct($settings = null)
    {
        $settings = $this->refineSettings($settings);
        $this->paddingStr = $settings->getPaddingStr() ?? SettingsInterface::EMPTY;
        $this->messageStr = $this->refineMessage($settings);
        $this->setFields();
        $this->styled = new Styling(static::SYMBOLS, $this->getStyles());
    }

    /**
     * @param mixed $settings
     * @return Settings
     */
    protected function refineSettings($settings): Settings
    {
        $this->assertSettings($settings);
        if (\is_string($settings)) {
            return $this->defaultSettings()->setMessage($settings);
        }
        return $settings ?? $this->defaultSettings();
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
     * @return Settings
     */
    protected function defaultSettings(): Settings
    {
        return new Settings();
    }

    /**
     * @param Settings $settings
     * @return string
     */
    protected function refineMessage(Settings $settings): string
    {
        $message = ucfirst($settings->getMessage() ?? SettingsInterface::EMPTY);
        $prefix =
            empty($message) ?
                SettingsInterface::ONE_SPACE_SYMBOL :
                $settings->getPrefix() ?? SettingsInterface::ONE_SPACE_SYMBOL;
        $suffix =
            $settings->getSuffix() ??
            empty($message) ?
                SettingsInterface::EMPTY :
                SettingsInterface::DEFAULT_SUFFIX;
        return $prefix . $message . $suffix;
    }

    protected function setFields(): void
    {
        $this->percentPrefix = $this->getPrefix();
        $strLen =
            strlen($this->message()) + strlen($this->percent()) + strlen($this->paddingStr) + static::ERASING_SHIFT;
        $this->moveBackSequenceStr = ConsoleColor::ESC_CHAR . "[{$strLen}D";
        $this->eraseBySpacesStr = str_repeat(SettingsInterface::ONE_SPACE_SYMBOL, $strLen);
    }

    /**
     * @return string
     */
    protected function getPrefix(): string
    {
        if (strpos($this->messageStr, SettingsInterface::DEFAULT_SUFFIX)) {
            return SettingsInterface::ONE_SPACE_SYMBOL;
        }
        return SettingsInterface::EMPTY;
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

    protected function getStyles(): array
    {
        return static::STYLES;
    }

    public function interval(): float
    {
        return static::INTERVAL;
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->paddingStr = $inline ? SettingsInterface::ONE_SPACE_SYMBOL : SettingsInterface::EMPTY;
        $this->setFields();
        return $this;
    }

    /** {@inheritDoc} */
    public function begin(): string
    {
        return Cursor::hide() . $this->spin();
    }

    /** {@inheritDoc} */
    public function spin(?float $percent = null): string
    {
        if (null !== $percent) {
            $this->updatePercent($percent);
        }
        return
            $this->paddingStr .
            $this->styled->spinner() .
            $this->styled->message(
                $this->message()
            ) .
            $this->styled->percent(
                $this->percent()
            ) .
            $this->moveBackSequenceStr;
    }

    /**
     * @param float $percent
     */
    protected function updatePercent(float $percent): void
    {
        if (0 === (int)($percent * 1000) % 10) {
            $this->percentStr = Pretty::percent($percent, 0, $this->percentPrefix);
            $this->setFields();
        }
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        return $this->erase() . Cursor::show();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        return $this->eraseBySpacesStr . $this->moveBackSequenceStr;
    }
}
