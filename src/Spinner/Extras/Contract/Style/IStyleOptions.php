<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract\Style;

use IteratorAggregate;

interface IStyleOptions extends IteratorAggregate
{
    public function isEmpty(): bool;
}
