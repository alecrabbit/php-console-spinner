<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld;

use AlecRabbit\SpinnerOld\Core\Contracts\Juggler;
use AlecRabbit\SpinnerOld\Core\Contracts\Styles;
use AlecRabbit\SpinnerOld\Core\Spinner;
use AlecRabbit\SpinnerOld\Settings\Contracts\Defaults;
use AlecRabbit\SpinnerOld\Settings\Settings;

class TimeSpinner extends Spinner
{
    protected const INTERVAL = 0.5;
    protected const FRAMES = [];
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    Juggler::COLOR256 => Styles::DISABLED,
                    Juggler::COLOR => Styles::DISABLED,
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
    public function spin(): string
    {
        $this->message(date($this->timeFormat) ?: null);
        return parent::spin();
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        // $percent param is ignored
        return parent::begin();
    }

    /** {@inheritDoc} */
    protected function defaultSettings(): Settings
    {
        return
            parent::defaultSettings()
                ->setMessage(Defaults::EMPTY_STRING)
                ->setMessageSuffix(Defaults::EMPTY_STRING);
    }
}
