<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class StyleRenderer implements IStyleRenderer
{
    public function __construct(
        protected IStyleToAnsiStringConverter $converter,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyle $style): string
    {
        if ($style->isEmpty()) {
            throw new InvalidArgumentException('Style is empty.');
        }

        return $this->converter->convert($style);
    }
}
