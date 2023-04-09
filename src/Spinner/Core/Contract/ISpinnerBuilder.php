<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

interface ISpinnerBuilder
{
    public function build(): ILegacySpinner;

    public function withConfig(IConfig $config): self;
}
