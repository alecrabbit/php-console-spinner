<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;
use function AlecRabbit\Helpers\wcswidth;
use function AlecRabbit\typeOf;

/**
 * Class Sentinel.
 * Contains data asserts
 * @internal
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
     * @param string $frame
     */
    public static function assertFrameLength(string $frame): void
    {
        if (Defaults::MAX_FRAME_WIDTH < $length = wcswidth($frame)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Single frame max length [%s] exceeded [%s]',
                    Defaults::MAX_FRAME_WIDTH,
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
     * @param array $order
     */
    public static function assertJugglersOrder(array $order): void
    {
        if (Defaults::NUMBER_OF_ORDER_DIRECTIVES !== $count = count($order)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Incorrect count of order directives [%s] when exactly %s was expected',
                    $count,
                    Defaults::NUMBER_OF_ORDER_DIRECTIVES
                )
            );
        }
        foreach (Defaults::DEFAULT_ORDER_DIRECTIVES as $directive) {
            if (!in_array($directive, $order, true)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Directive for %s position not found',
                        Defaults::DIRECTIVES_NAMES[$directive]
                    )
                );
            }
        }
    }
}
