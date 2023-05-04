<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract;
use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Color\AnsiColorParser;

final class AnsiColorParserFactory implements Contract\IAnsiColorParserFactory
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
