<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ISimpleSpinner;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;

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
