<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\SequenceState;
use AlecRabbit\Spinner\Exception\NotImplemented;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SequenceStateTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spinnerState = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceState::class, $spinnerState);
    }

    public function getTesteeInstance(
        ?string $sequence = null,
        ?int $width = null,
        ?int $previousWidth = null,
    ): ISequenceState {
        return new SequenceState(
            sequence: $sequence ?? 's',
            width: $width ?? 1,
            previousWidth: $previousWidth ?? 0,
        );
    }

    #[Test]
    public function canBeInstantiatedWithValues(): void
    {
        $sequence = 'aa';
        $width = 2;
        $previousWidth = 1;

        $spinnerState = $this->getTesteeInstance(
            sequence: $sequence,
            width: $width,
            previousWidth: $previousWidth,
        );

        self::assertInstanceOf(SequenceState::class, $spinnerState);
        self::assertEquals($sequence, $spinnerState->getSequence());
        self::assertEquals($width, $spinnerState->getWidth());
        self::assertEquals($previousWidth, $spinnerState->getPreviousWidth());
    }
}
