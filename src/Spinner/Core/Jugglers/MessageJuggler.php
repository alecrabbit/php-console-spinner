<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class MessageJuggler
{
    /** @var string */
    protected $message;
    /** @var int */
    protected $erasingLength;
    /** @var string */
    protected $messagePrefix;
    /** @var string */
    protected $messageSuffix;
    /** @var string */
    protected $spacer = Defaults::EMPTY;

    public function __construct(string $message, int $erasingLength = null)
    {
        $this->updateMessage($message, $erasingLength);
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

    /**
     * @param string $message
     * @param null|int $erasingLength
     */
    protected function updateMessage(string $message, ?int $erasingLength): void
    {
        $this->message = $message;
        if (Defaults::EMPTY === $message) {
            $this->erasingLength = 0;
            $this->messageSuffix = Defaults::EMPTY;
        } else {
            $this->erasingLength = $this->refineErasingLen($message, $erasingLength);
            $this->messageSuffix = Defaults::DEFAULT_SUFFIX;
        }
    }

}