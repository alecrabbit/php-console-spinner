<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\Juggler;
use AlecRabbit\Spinner\Core\Contracts\Styles;
use AlecRabbit\Spinner\Core\Spinner;

class PercentSpinner extends Spinner
{
    protected const INTERVAL = 0.1;
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
    public function message(?string $message = null): Spinner
    {
        return $this;
    }
}
