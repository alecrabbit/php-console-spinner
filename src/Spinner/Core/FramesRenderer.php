<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\A\AFramesRenderer;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

use function is_array;
use function is_string;

final class FramesRenderer extends AFramesRenderer
{
    /** @inheritdoc */
    protected function createFrame(mixed $entry): IFrame
    {
        if (is_string($entry)) {
            return
                new Frame($entry, WidthDeterminer::determine($entry));
        }
        if (is_array($entry)) {
            self::assertEntryArray($entry);
            return
                new Frame($entry[0], $entry[1]);
        }
        throw new InvalidArgumentException(
            sprintf(
                'Unknown frame entry type: %s',
                get_debug_type($entry)
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
        // second element should non-negative integer
        $second = $entry[1];
        if (!is_int($second) || $second < 0) {
            throw new InvalidArgumentException(
                sprintf(
                    'Second element of entry array should be non-negative integer, %s given.',
                    get_debug_type($second)
                )
            );
        }
    }
}