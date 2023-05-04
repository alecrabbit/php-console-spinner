<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFactory;

final class StyleFactory implements IStyleFactory
{
    public function fromString(string $entry): IStyle
    {
        return new Style(fgColor: $entry);
    }
}
