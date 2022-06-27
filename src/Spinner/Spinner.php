<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;

final class Spinner extends ABaseSpinner implements ISpinner
{
    private Core\Twirler\Factory\Contract\ITwirlerFactory $twirlerFactory;

    public function __construct(IConfig $config)
    {
        parent::__construct($config);
        $this->twirlerFactory = $config->getTwirlerFactory();
    }

    public function spinner(ITwirler|string|null $twirler): void
    {
        $this->container->spinner($twirler);
    }

    public function progress(float|ITwirler|string|null $twirler): void
    {
        $this->container->progress($twirler);
    }

    public function message(ITwirler|string|null $twirler): void
    {
        $this->container->message($twirler);
    }
}
