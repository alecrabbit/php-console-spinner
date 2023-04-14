<?php

declare(strict_types=1);
// 13.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Render\StyleRenderer;

final class StyleRendererFactory implements Contract\IStyleRendererFactory
{
    public function __construct(
        protected IStyleToAnsiStringConverterFactory $converterFactory,
    ) {
    }

    public function create(OptionStyleMode $styleMode): IStyleRenderer
    {
        return
            new StyleRenderer(
                converter: $this->converterFactory->create($styleMode),
            );
    }
}
