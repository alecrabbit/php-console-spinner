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
    protected $currentSuffix;
    /** @var string */
    protected $suffixFromSettings;

    /** {@inheritDoc} */
    public function __construct(Settings $settings, Style $style)
    {
        $this->init($style);
        $this->suffixFromSettings = $settings->getMessageSuffix();
        $this->updateMessage(
            $settings->getMessage()
        );
    }

    /**
     * @param null|string $message
     */
    protected function updateMessage(?string $message): void
    {
        $message = $message ?? Defaults::EMPTY_STRING;
        $this->message = $this->refineMessage($message);
        if (Defaults::EMPTY_STRING === $this->message) {
            $this->erasingLength = 0;
            $this->currentSuffix = Defaults::EMPTY_STRING;
        } else {
            $this->erasingLength = Calculator::computeErasingLength($this->message);
            $this->currentSuffix = $this->suffixFromSettings;
        }
        $this->frameString =
            $this->message . $this->currentSuffix;

        $this->currentFrameErasingLength =
            mb_strwidth($this->currentSuffix . $this->spacer) + $this->erasingLength + $this->formatErasingShift;
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
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->updateMessage($message);
    }

    /** {@inheritDoc} */
    protected function getCurrentFrame(): string
    {
        return $this->frameString;
    }
}
