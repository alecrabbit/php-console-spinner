<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerContainer;
use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;

final class Spinner extends ABaseSpinner
{
    public function getInterval(): IWInterval
    {
        return $this->container->getInterval();
    }

    public function spinner(IRevolveWiggler|string|null $wiggler): void
    {
        $this->wrap(
            $this->container->spinner(...),
            $wiggler
        );
    }

    public function progress(string|IProgressWiggler|float|null $wiggler): void
    {
        $this->wrap(
            $this->container->progress(...),
            $wiggler
        );
    }

    public function message(string|IMessageWiggler|null $wiggler): void
    {
        $this->wrap(
            $this->container->message(...),
            $wiggler
        );
    }
}
