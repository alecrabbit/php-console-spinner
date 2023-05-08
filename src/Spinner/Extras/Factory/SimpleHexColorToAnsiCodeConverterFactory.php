<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Extras\Color\SimpleHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

final class SimpleHexColorToAnsiCodeConverterFactory implements Contract\IHexColorToAnsiCodeConverterFactory
{
    public function create(OptionStyleMode $styleMode): IHexColorToAnsiCodeConverter
    {
        return new SimpleHexColorToAnsiCodeConverter($styleMode);
    }
}
