<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\AWBaseSpinner;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Kernel\Contract\IWSimpleSpinner;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;

final class WSimpleSpinner extends AWBaseSpinner implements IWSimpleSpinner
{
    protected IWigglerContainer $wigglers;

    public function __construct(IConfig $config)
    {
        parent::__construct($config);
        $this->wigglers = $config->getWigglers();
    }

    public function getInterval(): IWInterval
    {
        return $this->wigglers->getInterval();
    }

    public function spinner(IRevolveWiggler|string|null $wiggler): void
    {
        $this->wrap(
            $this->wigglers->spinner(...),
            $wiggler
        );
    }

    public function progress(string|IProgressWiggler|float|null $wiggler): void
    {
        $this->wrap(
            $this->wigglers->progress(...),
            $wiggler
        );
    }

    public function message(string|IMessageWiggler|null $wiggler): void
    {
        $this->wrap(
            $this->wigglers->message(...),
            $wiggler
        );
    }
}
