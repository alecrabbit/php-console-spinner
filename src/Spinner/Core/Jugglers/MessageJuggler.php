<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Core\Coloring\Style;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;

class MessageJuggler extends AbstractJuggler
{
    /** @var string */
    protected $message;
    /** @var int */
    protected $erasingLength;
    /** @var string */
    protected $frameString;
    /** @var string */
    protected $suffix;

    public function __construct(Settings $settings, Style $style)
    {
        $this->init($style);
        $this->updateMessage($settings->getMessage(), $settings->getMessageErasingLength());
    }

    /**
     * @param null|string $message
     * @param null|int $erasingLength
     */
    protected function updateMessage(?string $message, ?int $erasingLength): void
    {
        $this->message = $this->refineMessage($message);
        if (Defaults::EMPTY_STRING === $this->message) {
            $this->erasingLength = 0;
            $this->suffix = Defaults::EMPTY_STRING;
        } else {
            $erasingLength = $this->refineErasingLen($this->message, $erasingLength);
            $this->erasingLength = $erasingLength;
            $this->suffix = Defaults::DOTS_SUFFIX;
        }
        $this->frameString =
            $this->message . $this->suffix;

        $this->currentFrameErasingLength =
            strlen($this->suffix . $this->spacer) + $this->erasingLength + $this->formatErasingShift;
    }

    /**
     * @param null|string $message
     * @return string
     */
    protected function refineMessage(?string $message): string
    {
        return ucfirst($message ?? Defaults::EMPTY_STRING);
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

    /**
     * @return string
     */
    protected function getCurrentFrame(): string
    {
        return $this->frameString;
    }
}
