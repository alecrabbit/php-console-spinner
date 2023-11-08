<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopCreator;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassExtractor;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Loop\LoopCreatorClassExtractor;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Stub\LoopProbeStub;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class LoopCreatorClassExtractorTest extends TestCase
{
    public static function canExtractCreatorClassDataProvider(): iterable
    {
        yield from [
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => sprintf(
                            'Probe must be an instance of "%s" interface.',
                            ILoopProbe::class
                        ),
                    ],
                ],
                [stdClass::class]
            ],
            [[null], []],
            [[RevoltLoopCreator::class], [LoopProbeStub::class]],

        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $extractor = $this->getTesteeInstance();

        self::assertInstanceOf(LoopCreatorClassExtractor::class, $extractor);
    }

    public function getTesteeInstance(): ILoopCreatorClassExtractor
    {
        return
            new LoopCreatorClassExtractor();
    }

    #[Test]
    #[DataProvider('canExtractCreatorClassDataProvider')]
    public function canExtractCreatorClass(array $expected, array $probes): void
    {
        $expectedException = $this->expectsException($expected);

        $result = $expected[0] ?? null;

        $extractor = $this->getTesteeInstance();

        self::assertSame($result, $extractor->extract(new ArrayObject($probes)));

        if ($expectedException) {
            self::failTest($expectedException);
        }
    }

}
