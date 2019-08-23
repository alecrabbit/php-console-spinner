<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\typeOf;

class TimeSpinner extends AbstractSpinner
{
    protected const INTERVAL = 1;
    protected const FRAMES = [];
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
    protected function defaultSettings(): Settings
    {
        return
            parent::defaultSettings()
                ->setMessagePrefix(Defaults::EMPTY)
                ->setMessageSuffix(Defaults::EMPTY);
    }
}
