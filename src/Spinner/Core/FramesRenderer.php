<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFramesRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Stringable;

use function is_array;
use function is_string;

final class FramesRenderer extends AFramesRenderer
{
    /** @inheritdoc */
    protected function createFrame(mixed $entry): IFrame
    {
        if ($entry instanceof Stringable) {
            $entry = (string)$entry;
        }
        if (is_int($entry)) {
            $entry = (string)$entry;
        }
        if (is_string($entry)) {
            return
                FrameFactory::create($entry, WidthDeterminer::determine($entry));
        }
        if (is_array($entry)) {
            self::assertEntryArray($entry);
            return
                FrameFactory::create(
                    (string)$entry[0],
                    self::refineNullableInt($entry[1])
                );
        }
        throw new InvalidArgumentException(
            sprintf(
                'Unsupported frame entry type: %s, allowed types: int, string, array, Stringable.',
                get_debug_type($entry),
            )
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertEntryArray(array $entry): void
    {
        // array size should be 2
        $size = count($entry);
        if (2 !== $size) {
            throw new InvalidArgumentException(
                sprintf(
                    'Entry array size should be 2, %d given',
                    $size
                )
            );
        }
        // first element should be string
        $first = $entry[0];
        if (!is_string($first)) {
            throw new InvalidArgumentException(
                sprintf(
                    'First element of entry array should be string, %s given',
                    get_debug_type($first)
                )
            );
        }
        // second element should be non-negative integer
        $second = self::refineNullableInt($entry[1]);
        if (null === $second) {
            return;
        }
        if (!is_int($second) || $second < 0) {
            throw new InvalidArgumentException(
                sprintf(
                    'Second element of entry array should be non-negative integer, %s given.',
                    get_debug_type($second)
                )
            );
        }
    }

    protected static function refineNullableInt(mixed $value): ?int
    {
        if (null === $value) {
            return null;
        }
        return (int)$value;
    }
}
