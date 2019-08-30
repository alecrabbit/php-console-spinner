<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\typeOf;

class PercentSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
    protected const FRAMES = [];
    protected const
        STYLES =
        [
            Juggler::FRAMES_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];

    /** {@inheritDoc} */
    public function spin(?float $percent = null): string
    {
        $percent and $this->progress($percent);
        return parent::spin();
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        return parent::begin(0.0);
    }

    /** {@inheritDoc} */
    public function message(?string $message = null, ?int $erasingLength = null): Spinner
    {
        return $this;
    }

//    /** {@inheritDoc} */
//    public function progress(?float $percent): Spinner
//    {
//        return $this;
//    }

    /** {@inheritDoc} */
    protected function defaultSettings(): Settings
    {
        return
            parent::defaultSettings()
                ->setMessagePrefix(Defaults::EMPTY_STRING);
    }
}
