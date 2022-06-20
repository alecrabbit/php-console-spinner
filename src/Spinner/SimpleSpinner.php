<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Kernel\Contract\IDriver;
use AlecRabbit\Spinner\Kernel\Contract\ICharFrame;
use AlecRabbit\Spinner\Kernel\Contract\ISimpleSpinner;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;

use const PHP_EOL;

final class SimpleSpinner extends ABaseSpinner implements ISimpleSpinner
{
    protected IWigglerContainer $wigglers;

    public function __construct(IConfig $config)
    {
        parent::__construct($config);
        $this->wigglers = $config->getWigglers();
    }

    public function getInterval(): IInterval
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
