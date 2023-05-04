<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract\Style;

interface IStyleOptionsParser
{
    public function parseOptions(?IStyleOptions $options): iterable;
}
