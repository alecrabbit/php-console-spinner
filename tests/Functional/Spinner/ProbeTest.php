<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Contract\IStaticProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Probe;
use AlecRabbit\Tests\Functional\Spinner\Override\StaticProbeOverride;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ProbeTest extends TestCaseWithPrebuiltMocksAndStubs
{
//    #[Test]
//    public function canNotBeInstantiated(): void
//    {
//        $this->expectException(\Error::class);
//        $this->expectExceptionMessage('Call to private AlecRabbit\Spinner\Probe::__construct()');
//        $probe = new Probe();
//    }

    private array $probes = [];

    #[Test]
    public function canRegisterProbe(): void
    {
        $probe = RevoltLoopProbe::class;
        Probe::register($probe);

        $probes = self::getPropertyValue('probes', Probe::class);
        self::assertContains($probe, $probes);
    }

    #[Test]
    public function canLoadAllProbes(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;

        Probe::register($probe2);
        Probe::register($probe1);

        $probes = iterator_to_array(Probe::load());
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
    }

    #[Test]
    public function canRegisterMultipleProbes(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeOverride::class;

        Probe::register($probe3);
        Probe::register($probe2, $probe1);

        $probes = iterator_to_array(Probe::load());
        self::assertCount(3, $probes);
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
        self::assertContains($probe3, $probes);
    }
    #[Test]
    public function reRegisteringProbeHasNoEffect(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeOverride::class;

        Probe::register($probe3);
        Probe::register($probe2, $probe1);
        Probe::register($probe1);
        Probe::register($probe3);

        $probes = iterator_to_array(Probe::load());
        self::assertCount(3, $probes);
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
        self::assertContains($probe3, $probes);
    }

    #[Test]
    public function canLoadSpecificSubClassProbes(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeOverride::class;

        Probe::register($probe2);
        Probe::register($probe1);
        Probe::register($probe3);

        $probes = iterator_to_array(Probe::load(ILoopProbe::class));
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
        self::assertNotContains($probe3, $probes);
    }

    #[Test]
    public function loadsAllProbesIfFilterClassIsNull(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe3 = StaticProbeOverride::class;

        Probe::register($probe3);
        Probe::register($probe1);

        $probes = iterator_to_array(Probe::load());
        self::assertContains($probe1, $probes);
        self::assertContains($probe3, $probes);
    }

    #[Test]
    public function throwsIfProbeClassIsNotAStaticProbeSubClass(): void
    {
        $probe = \stdClass::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $probe .
            '" must implement "' .
            IStaticProbe::class .
            '" interface.'
        );
        Probe::register($probe);
        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfProbeClassIsNotAStaticProbeSubClass2(): void
    {
        $probe = '';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $probe .
            '" must implement "' .
            IStaticProbe::class .
            '" interface.'
        );
        Probe::register($probe);
        self::fail('Exception was not thrown.');
    }

    protected function setUp(): void
    {
        $this->probes = self::getPropertyValue('probes', Probe::class);
        self::setPropertyValue(Probe::class, 'probes', []);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Probe::class, 'probes', $this->probes);
    }
}
