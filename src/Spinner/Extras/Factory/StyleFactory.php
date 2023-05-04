<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Extras\Color\Style\Style;

final class StyleFactory implements IStyleFactory
{
    public function fromString(string $entry): IStyle
    {
        return new Style(fgColor: $entry);
    }
}
