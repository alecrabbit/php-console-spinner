<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;

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
