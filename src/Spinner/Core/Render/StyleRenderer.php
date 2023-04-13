<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;

final class StyleRenderer implements IStyleRenderer
{

    public function __construct()
    {
    }

    public function render(IStyle $style, OptionStyleMode $mode): string
    {
        // TODO: Implement render() method.
    }
}
