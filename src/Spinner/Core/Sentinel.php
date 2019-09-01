<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;

/**
 * Class Sentinel
 * Contains data asserts
 */
class Sentinel
{
    /**
     * @param array $frames
     */
    public static function assertFrames(array $frames): void
    {
        if (Defaults::MAX_FRAMES_COUNT < $count = count($frames)) {
            throw new \InvalidArgumentException(
                sprintf('MAX_SYMBOLS_COUNT limit [%s] exceeded: [%s].', Defaults::MAX_FRAMES_COUNT, $count)
            );
        }
        foreach ($frames as $frame) {
            self::assertFrame($frame);
        }
    }

    /**
     * @param mixed $frame
     */
    public static function assertFrame($frame): void
    {
        if (!\is_string($frame)) {
            throw new \InvalidArgumentException('All frames should be of string type.');
        }
        if (Defaults::MAX_FRAME_LENGTH < $length = mb_strlen($frame)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Single frame max length [%s] exceeded [%s]',
                    Defaults::MAX_FRAME_LENGTH,
                    $length
                )
            );
        }
    }

    /**
     * @param array $styles
     * @param array $against
     */
    public static function assertStyles(array $styles, array $against): void
    {
        $keys = array_keys($against);
        foreach ($keys as $index) {
            if (!\array_key_exists($index, $styles)) {
                // @codeCoverageIgnoreStart
                throw new \InvalidArgumentException(
                    'Styles array does not have [' . $index . '] key.'
                );
                // @codeCoverageIgnoreEnd
            }
        }
    }
}
