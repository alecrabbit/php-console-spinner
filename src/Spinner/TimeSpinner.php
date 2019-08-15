<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;
use function AlecRabbit\typeOf;

class TimeSpinner extends Spinner
{
    protected const INTERVAL = 1;
    protected const FRAMES = null;
    protected const
        STYLES =
        [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];

    /** @var string */
    protected $timeFormat = 'T Y-m-d H:i:s';

    /**
     * @param string $timeFormat
     * @return TimeSpinner
     */
    public function setTimeFormat(string $timeFormat): TimeSpinner
    {
        $this->timeFormat = $timeFormat;
        return $this;
    }

    /** {@inheritDoc} */
    public function spin(?float $percent = null, ?string $message = null): string
    {
        return parent::spin(null, date($this->timeFormat) ?: '');
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        return parent::begin();
    }

    /** {@inheritDoc} */
    protected function defaultSettings(): SettingsInterface
    {
        return
            parent::defaultSettings()
                ->setMessagePrefix(SettingsInterface::EMPTY)
                ->setMessageSuffix(SettingsInterface::EMPTY);
    }
}
