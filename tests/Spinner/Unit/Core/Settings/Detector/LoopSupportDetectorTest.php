<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopSupportDetector;
use AlecRabbit\Tests\Spinner\Unit\Core\Settings\Detector\Override\LoopCreatorOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class LoopSupportDetectorTest extends TestCase
{
    public static function canDetectDataProvider(): iterable
    {
        yield from [
            // $result, $probes
            [false, null],
            [false, stdClass::class],
            [true, LoopCreatorOverride::class],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $detector = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSupportDetector::class, $detector);
    }

    protected function getTesteeInstance(
        ?string $creatorClass = null
    ): ILoopSupportDetector {
        return
            new LoopSupportDetector(
                creatorClass: $creatorClass,
            );
    }

    #[Test]
    #[DataProvider('canDetectDataProvider')]
    public function canDetect(bool $result, ?string $creatorClass): void
    {
        $detector = $this->getTesteeInstance(
            creatorClass: $creatorClass,
        );

        self::assertEquals($result, $detector->getSupportValue());
    }
}
