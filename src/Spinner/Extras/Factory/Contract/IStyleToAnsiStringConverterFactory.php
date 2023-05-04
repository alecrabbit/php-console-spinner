<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleToAnsiStringConverter;

interface IStyleToAnsiStringConverterFactory
{
    public function create(OptionStyleMode $styleMode): IStyleToAnsiStringConverter;
}
