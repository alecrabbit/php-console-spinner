<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;
use AlecRabbit\Spinner\Core\Spinner;
use function AlecRabbit\typeOf;

class PercentSpinner extends Spinner
{
    protected const ERASING_SHIFT = 1;
    protected const INTERVAL = 0.1;
    protected const SYMBOLS = null;
    protected const
        STYLES =
        [
            StylesInterface::SPINNER_STYLES =>
                [
                    StylesInterface::COLOR256 => StylesInterface::DISABLED,
                    StylesInterface::COLOR => StylesInterface::DISABLED,
                ],
        ];

    public function spin(?float $percent = null): string
    {
        if (!\is_float($percent)) {
            throw new \RuntimeException('Float percentage value expected ' . typeOf($percent) . ' given.');
        }
        return parent::spin($percent);
    }

    public function begin(?float $percent = null): string
    {
        return parent::begin(0.0);
    }

    /**
     * @return SettingsInterface
     */
    protected function defaultSettings(): SettingsInterface
    {
        return
            parent::defaultSettings()
                ->setPrefix(SettingsInterface::EMPTY);
    }
}
