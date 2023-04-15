<?php

declare(strict_types=1);
// 14.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Core\Render\StyleToAnsiStringConverter;

final class StyleToAnsiStringConverterFactory implements IStyleToAnsiStringConverterFactory
{
    public function __construct(
        protected IHexColorToAnsiCodeConverterFactory $converterFactory,
    ) {
    }

    public function create(OptionStyleMode $styleMode): IStyleToAnsiStringConverter
    {
        return
            new StyleToAnsiStringConverter(
                parser: $this->converterFactory->create($styleMode),
            );
    }
}
