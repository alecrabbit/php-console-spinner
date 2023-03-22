<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Stringable;

use function is_string;

final class FrameRenderer extends AFrameRenderer
{

    protected function createFromInt(int $entry): IFrame
    {
        return
            $this->createFromString((string)$entry);
    }

    protected function createFromString(string $entry): IFrame
    {
        return FrameFactory::create($entry, WidthDeterminer::determine($entry));
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function createFromArray(array $entry): IFrame
    {
        self::assertEntryArray($entry);
        return
            FrameFactory::create(
                (string)$entry[0],
                self::refineNullableInt($entry[1])
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assertEntryArray(array $entry): void
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
        if (!is_string($first) && !($first instanceof Stringable)) {
            throw new InvalidArgumentException(
                sprintf(
                    'First element of entry array should be string|Stringable, %s given.',
                    get_debug_type($first)
                )
            );
        }
        // second element should be non-negative integer
        $second = $entry[1] ?? null;
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

    protected function createFrame(int|string $entry): IFrame
    {
        return FrameFactory::create((string)$entry, WidthDeterminer::determine((string)$entry));
    }
}
