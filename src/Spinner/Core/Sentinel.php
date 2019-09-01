<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\typeOf;

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
        self::assertFrameLength($frame);
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

    /**
     * @param mixed $output
     */
    public static function assertOutput($output): void
    {
        if (null !== $output && false !== $output && !$output instanceof OutputInterface) {
            $typeOrValue =
                true === $output ? 'true' : typeOf($output);
            throw new \InvalidArgumentException(
                'Incorrect parameter: ' .
                '[null|false|' . OutputInterface::class . '] expected'
                . ' "' . $typeOrValue . '" given.'
            );
        }
    }

    /**
     * @param mixed $settings
     */
    public static function assertSettings($settings): void
    {
        if (null !== $settings && !\is_string($settings) && !$settings instanceof Settings) {
            throw new \InvalidArgumentException(
                'Instance of [' . Settings::class . '] or string expected ' . typeOf($settings) . ' given.'
            );
        }
    }

    /**
     * @param $frame
     */
    public static function assertFrameLength($frame): void
    {
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
}
