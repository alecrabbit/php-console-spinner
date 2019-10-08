<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Spinner\Core\Adapters\AbstractOutputAdapter;

class BufferOutputAdapter extends AbstractOutputAdapter
{
    /** @var string */
    protected $buffer;

    public function __construct()
    {
    }

    /** {@inheritDoc} */
    public function write($messages, $newline = false, $options = 0): void
    {
        if (!is_iterable($messages)) {
            $messages = [$messages];
        }
        foreach ($messages as $message) {
            $this->buffer .= $message;
        }
    }

    /**
     * @return string
     */
    public function getBuffer(): string
    {
        $buffer = $this->buffer;
        $this->buffer = '';
        return $buffer;
    }

    /**
     * @return resource
     */
    public function getStream()
    {
        return STDERR;
    }
}
