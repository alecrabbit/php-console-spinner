<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\SpinnerState;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerStateTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spinnerState = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerState::class, $spinnerState);
    }

    public function getTesteeInstance(
        ?string $sequence = null,
        ?int $width = null,
        ?int $previousWidth = null,
    ): ISpinnerState {
        return new SpinnerState(
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

        self::assertInstanceOf(SpinnerState::class, $spinnerState);
        self::assertEquals($sequence, $spinnerState->getSequence());
        self::assertEquals($width, $spinnerState->getWidth());
        self::assertEquals($previousWidth, $spinnerState->getPreviousWidth());
    }
}
