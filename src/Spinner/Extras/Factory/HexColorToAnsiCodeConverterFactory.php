<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Color\HexColorToAnsiCodeConverter;

final class HexColorToAnsiCodeConverterFactory implements IHexColorToAnsiCodeConverterFactory
{
    public function create(OptionStyleMode $styleMode): IHexColorToAnsiCodeConverter
    {
        return new HexColorToAnsiCodeConverter($styleMode);
    }
}
