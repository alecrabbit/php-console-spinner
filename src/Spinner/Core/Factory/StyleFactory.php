<?php

declare(strict_types=1);
// 13.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Core\Color\Style\Style;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;

final class StyleFactory implements IStyleFactory
{
    public function fromString(string $entry): IStyle
    {
        return new Style(fgColor: $entry);
    }
}
