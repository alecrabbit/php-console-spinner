<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class MessageJuggler implements JugglerInterface
{
    /** @var string */
    protected $messagePrefix = Defaults::EMPTY_STRING;
    /** @var string */
    protected $message;
    /** @var string */
    protected $messageSuffix = Defaults::EMPTY_STRING;
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;
    /** @var int */
    protected $erasingLength;
    /** @var string */
    protected $frameString;
    /** @var int */
    protected $frameStringErasingLength;
    /** @var int */
    protected $erasingLengthDelta;
    /** @var Circular */
    protected $style;

    public function __construct(string $message, int $erasingLength = null, Circular $style = null)
    {
        $this->style = $style ?? new Circular(['%s',]);
        $this->updateMessage($message, $erasingLength);
    }

    /**
     * @param string $message
     * @param null|int $erasingLength
     */
    protected function updateMessage(string $message, ?int $erasingLength): void
    {
        $this->message = $this->refineMessage($message);
        if (Defaults::EMPTY_STRING === $this->message) {
            $this->erasingLengthDelta = $this->getMessageFullLength();
            $this->erasingLength = 0;
            $this->spacer = Defaults::EMPTY_STRING;
            $this->messagePrefix = Defaults::DEFAULT_PREFIX;
            $this->messageSuffix = Defaults::EMPTY_STRING;
        } else {
            $erasingLength = $this->refineErasingLen($this->message, $erasingLength);
            $this->erasingLengthDelta = $this->getMessageFullLength() - $erasingLength;
            $this->erasingLength = $erasingLength;
            $this->spacer = Defaults::ONE_SPACE_SYMBOL;
            $this->messagePrefix = Defaults::DEFAULT_PREFIX;
            $this->messageSuffix = Defaults::DEFAULT_SUFFIX;
        }
        $this->frameString =
            $this->messagePrefix . $this->message . $this->messageSuffix . $this->spacer;

        $this->frameStringErasingLength =
            strlen($this->spacer . $this->messagePrefix . $this->messageSuffix) + $this->erasingLength;
    }

    /**
     * @param string $message
     * @return string
     */
    protected function refineMessage(string $message): string
    {
        return ucfirst($message);
    }

    /**
     * @return int
     */
    protected function getMessageFullLength(): int
    {
        return strlen($this->messagePrefix) + $this->erasingLength + strlen($this->messageSuffix);
    }

    /**
     * @param string $message
     * @param null|int $erasingLength
     * @return int
     */
    protected function refineErasingLen(string $message, ?int $erasingLength): int
    {
        if (null === $erasingLength) {
            return Calculator::computeErasingLength([$message]);
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

//    /** {@inheritDoc} */
//    public function getFrame(): string
//    {
//        return $this->frameString;
//    }
//
    /** {@inheritDoc} */
    public function getStyledFrame(): string
    {
        return
            sprintf((string)$this->style->value(), $this->frameString);
    }

    /** {@inheritDoc} */
    public function getFrameErasingLength(): int
    {
        return $this->frameStringErasingLength;
    }
}
