<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class MessageJuggler
{
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;
    /** @var string */
    protected $messagePrefix = Defaults::EMPTY;
    /** @var string */
    protected $message;
    /** @var string */
    protected $messageSuffix = Defaults::EMPTY;
    /** @var int */
    protected $erasingLength;
    /** @var string */
    protected $frameString;
    /** @var int */
    protected $frameStringErasingLength;

    public function __construct(string $message, int $erasingLength = null)
    {
        $this->updateMessage($message, $erasingLength);
    }

    /**
     * @param string $message
     * @param null|int $erasingLength
     */
    protected function updateMessage(string $message, ?int $erasingLength): void
    {
        $this->message = $message;
        if (Defaults::EMPTY === $message) {
            $this->erasingLength = 0;
        } else {
            $this->erasingLength = $this->refineErasingLen($message, $erasingLength);
            $this->messageSuffix = Defaults::DEFAULT_SUFFIX;
        }
        $this->frameString =
            $this->spacer . $this->messagePrefix . $this->message . $this->messageSuffix;

        $this->frameStringErasingLength =
            strlen($this->spacer . $this->messagePrefix . $this->messageSuffix) + $this->erasingLength;
    }

    /**
     * @param string $message
     * @param null|int $erasingLength
     * @return int
     */
    protected function refineErasingLen(string $message, ?int $erasingLength): int
    {
        if (null === $erasingLength) {
            return Calculator::computeErasingLen([$message]);
        }
        return $erasingLength;
    }

    /**
     * @param string $message
     * @param null|int $erasingLength
     */
    public function setMessage(string $message, ?int $erasingLength = null): void
    {
        $this->updateMessage($message, $erasingLength);
    }

    public function getFrame(): string
    {
        return $this->frameString;
    }

    public function getFrameErasingLength(): int
    {
        return $this->frameStringErasingLength;
    }
}