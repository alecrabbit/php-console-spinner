<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\SpinnerBuilder;

interface ISpinnerBuilder
{
    public function build(): ISpinner;

    public function withConfig(IConfig $config): self;
}
