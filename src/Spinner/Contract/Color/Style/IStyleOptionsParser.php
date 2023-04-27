<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract\Color\Style;

interface IStyleOptionsParser
{
    public function parseOptions(?IStyleOptions $options): iterable;
}
