<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\AMultiSpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirler;
use AlecRabbit\Spinner\Core\Twirler\Factory\Contract\ITwirlerFactory;

final class Spinner extends AMultiSpinner implements ISpinner
{
    private ITwirlerFactory $twirlerFactory;

    public function __construct(IConfig $config)
    {
        parent::__construct($config);
        $this->twirlerFactory = $config->getTwirlerFactory();
    }

    public function spinner(ITwirler|string|null $value): void
    {
        if (!$value instanceof ITwirler) {
            $value = $this->twirlerFactory->spinner($value);
        }
        $this->container->spinner($value);
    }

    public function progress(float|ITwirler|string|null $value): void
    {
        if (!$value instanceof ITwirler) {
            $value = $this->twirlerFactory->progress($value);
        }
        $this->container->progress($value);
    }

    public function message(ITwirler|string|null $value): void
    {
        if (!$value instanceof ITwirler) {
            $value = $this->twirlerFactory->message($value);
        }
        $this->container->message($value);
    }
}
