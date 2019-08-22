<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

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
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];

    /** {@inheritDoc} */
    public function spin(?float $percent = null, ?string $message = null): string
    {
        if (!\is_float($percent)) {
            throw new \RuntimeException('Float percentage value expected ' . typeOf($percent) . ' given.');
        }
        if (null !== $message) {
            throw new \RuntimeException('Null value expected ' . typeOf($message) . ' given.');
        }
        return parent::spin($percent);
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        return parent::begin(0.0);
    }

    /**
     * @return Settings
     */
    protected function defaultSettings(): Settings
    {
        return
            parent::defaultSettings()
                ->setMessagePrefix(Defaults::EMPTY);
    }
}
