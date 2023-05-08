<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Extras\Color\AnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;

final class AnsiColorParserFactory implements IAnsiColorParserFactory
{
    public function __construct(
        protected IHexColorToAnsiCodeConverterFactory $converterFactory,
    ) {
    }

    public function create(OptionStyleMode $styleMode): IAnsiColorParser
    {
        return new AnsiColorParser(
            converter: $this->converterFactory->create($styleMode),
        );
    }
}
