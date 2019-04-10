<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Pretty;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\Spinner\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;
use function AlecRabbit\typeOf;

abstract class AbstractSpinner implements SpinnerInterface
{
    protected const ERASING_SHIFT = 1;
    protected const INTERVAL = 0.1;

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
    public function __construct(
        $settings = null
    ) {
        $settings = $this->refineSettings($settings);
        $this->paddingStr = $settings->getPaddingStr() ?? SpinnerInterface::EMPTY;
        $this->messageStr = $this->refineMessage($settings);
        $this->setFields();
        $this->styled = new Styling($this->getSymbols(), $this->getStyles());
    }

    /**
     * @param mixed $settings
     * @return Settings
     */
    protected function refineSettings($settings): Settings
    {
        $this->assertSettings($settings);
        if (\is_string($settings)) {
            return (new Settings())->setMessage($settings);
        }
        return $settings ?? new Settings();
    }

    /**
     * @param mixed $settings
     */
    protected function assertSettings($settings): void
    {
        if (null !== $settings && !\is_string($settings) && !$settings instanceof SettingsInterface) {
            throw new \InvalidArgumentException(
                'String or instance of SettingsInterface expected ' . typeOf($settings) . ' given.'
            );
        }
    }

    /**
     * @param Settings $settings
     * @return string
     */
    protected function refineMessage(Settings $settings): string
    {
        $message = ucfirst($settings->getMessage() ?? SpinnerInterface::ONE_SPACE_SYMBOL);
        $prefix =
            empty($message) ? SpinnerInterface::EMPTY : $settings->getPrefix() ?? SpinnerInterface::ONE_SPACE_SYMBOL;
        $suffix =
            $settings->getSuffix() ??
            (empty($message) || SpinnerInterface::ONE_SPACE_SYMBOL === $message ?
                SpinnerInterface::EMPTY :
                SpinnerInterface::DEFAULT_SUFFIX);
        return $prefix . $message . $suffix;
    }

    protected function setFields(): void
    {
        $this->percentPrefix = $this->getPrefix();
        $strLen =
            strlen($this->message()) + strlen($this->percent()) + strlen($this->paddingStr) + static::ERASING_SHIFT;
        $this->moveBackSequenceStr = ConsoleColor::ESC_CHAR . "[{$strLen}D";
        $this->eraseBySpacesStr = str_repeat(SpinnerInterface::ONE_SPACE_SYMBOL, $strLen);
    }

    /**
     * @return string
     */
    protected function getPrefix(): string
    {
        if ($this->messageStr !== str_repeat(SpinnerInterface::ONE_SPACE_SYMBOL, 2)) {
            return SpinnerInterface::ONE_SPACE_SYMBOL;
        }
        return SpinnerInterface::EMPTY;
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

    /**
     * @return array
     */
    abstract protected function getSymbols(): array;

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => [
                '203',
                '209',
                '215',
                '221',
                '227',
                '191',
                '155',
                '119',
                '83',
                '84',
                '85',
                '86',
                '87',
                '81',
                '75',
                '69',
                '63',
                '99',
                '135',
                '171',
                '207',
                '206',
                '205',
                '204',
            ],
            Styling::COLOR_SPINNER_STYLES => ['96'],
        ];
    }

    public function interval(): float
    {
        return static::INTERVAL;
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->paddingStr = $inline ? SpinnerInterface::ONE_SPACE_SYMBOL : SpinnerInterface::EMPTY;
        $this->setFields();
        return $this;
    }

    /** {@inheritDoc} */
    public function begin(): string
    {
        return $this->spin();
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
        return $this->erase();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        return $this->eraseBySpacesStr . $this->moveBackSequenceStr;
    }
}
