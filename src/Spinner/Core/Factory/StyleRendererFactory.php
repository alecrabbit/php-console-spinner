<?php

declare(strict_types=1);
// 13.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Contract\Output\ISequencer;
use AlecRabbit\Spinner\Core\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Render\StyleRenderer;

final class StyleRendererFactory implements Contract\IStyleRendererFactory
{
    public function __construct(
        protected IAnsiStyleConverter $converter,
        protected ISequencer $sequencer,
    ) {
    }

    public function create(OptionStyleMode $styleMode): IStyleRenderer
    {
        return
            new StyleRenderer(
                converter: $this->converter,
                sequencer: $this->sequencer,
                styleMode: $styleMode,
            );
    }
}
