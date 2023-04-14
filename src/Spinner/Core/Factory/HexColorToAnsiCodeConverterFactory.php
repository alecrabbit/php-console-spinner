<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;

final class HexColorToAnsiCodeConverterFactory implements Contract\IHexColorToAnsiCodeConverterFactory
{
    public function create(OptionStyleMode $styleMode): IHexColorToAnsiCodeConverter
    {
        return new HexColorToAnsiCodeConverter($styleMode);
    }
}
