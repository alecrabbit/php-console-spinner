<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;

interface IStyleToAnsiStringConverterFactory
{
    public function create(OptionStyleMode $styleMode): IStyleToAnsiStringConverter;
}
