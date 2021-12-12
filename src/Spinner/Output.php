<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

final class Output implements Contract\IOutput
{

    public function write(iterable|string $messages): void
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $message) {
            echo $message;
        }
    }
}
