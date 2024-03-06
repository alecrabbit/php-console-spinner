<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Probes;

use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe;
use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Probes;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\Spinner\Functional\Probes\Stub\DummyInterfaceStub;
use AlecRabbit\Tests\Spinner\Functional\Probes\Stub\StaticProbeStub;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ProbesTest extends TestCase
{
    private const PROBES = 'probes';
    private array $probes = [];

    #[Test]
    public function canRegisterProbe(): void
    {
        $probe = RevoltLoopProbe::class;
        Probes::register($probe);

        $probes = self::getPropertyValue(Probes::class, self::PROBES);
        self::assertContains($probe, $probes);
    }

    #[Test]
    public function canLoadAllProbes(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = StaticProbeStub::class;

        Probes::register($probe2);
        Probes::register($probe1);

        $probes = iterator_to_array(Probes::load());

        self::assertCount(2, $probes);
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
    }

    #[Test]
    public function loadsProbesInAReverseOrder(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = StaticProbeStub::class;

        Probes::register($probe1);
        Probes::register($probe2);

        $probes = iterator_to_array(Probes::load());

        self::assertCount(2, $probes);
        self::assertSame($probe2, array_shift($probes));
        self::assertSame($probe1, array_shift($probes));
    }

    #[Test]
    public function canRegisterMultipleProbes(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeStub::class;

        Probes::register($probe3);
        Probes::register($probe2, $probe1);

        $probes = iterator_to_array(Probes::load());
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
        $probe3 = StaticProbeStub::class;

        Probes::register($probe3);
        Probes::register($probe2, $probe1);
        Probes::register($probe1);
        Probes::register($probe3);

        $probes = iterator_to_array(Probes::load());
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
        $probe3 = StaticProbeStub::class;

        Probes::register($probe2);
        Probes::register($probe1);
        Probes::register($probe3);

        $probes = iterator_to_array(Probes::load(ILoopProbe::class));
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
        self::assertNotContains($probe3, $probes);
    }

    #[Test]
    public function canUnregisterASpecificClassProbe(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeStub::class;

        Probes::register($probe2);
        Probes::register($probe1);
        Probes::register($probe3);

        Probes::unregister($probe2);

        $probes = iterator_to_array(Probes::load());

        self::assertContains($probe1, $probes);
        self::assertContains($probe3, $probes);
        self::assertNotContains($probe2, $probes);
    }

    #[Test]
    public function canUnregisterProbeOfInterfaceSubclass(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeStub::class;

        Probes::register($probe2);
        Probes::register($probe1);
        Probes::register($probe3);

        Probes::unregister(ILoopProbe::class);

        $probes = iterator_to_array(Probes::load());

        self::assertNotContains($probe1, $probes);
        self::assertNotContains($probe2, $probes);
        self::assertContains($probe3, $probes);
    }

    #[Test]
    public function canUnregisterProbeOfGeneralInterfaceSubclass(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeStub::class;

        Probes::register($probe2);
        Probes::register($probe1);
        Probes::register($probe3);

        Probes::unregister(IStaticProbe::class);

        $probes = iterator_to_array(Probes::load());

        self::assertNotContains($probe1, $probes);
        self::assertNotContains($probe2, $probes);
        self::assertNotContains($probe3, $probes);
    }

    #[Test]
    public function unregisteringNonRegisteredProbeHasNoEffect(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeStub::class;

        Probes::register($probe1);
        Probes::register($probe3);

        Probes::unregister($probe2);

        $probes = iterator_to_array(Probes::load());

        self::assertContains($probe1, $probes);
        self::assertContains($probe3, $probes);
        self::assertNotContains($probe2, $probes);
    }

    #[Test]
    public function loadsAllProbesIfFilterClassIsNull(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe3 = StaticProbeStub::class;

        Probes::register($probe3);
        Probes::register($probe1);

        $probes = iterator_to_array(Probes::load());

        self::assertContains($probe1, $probes);
        self::assertContains($probe3, $probes);
    }

    #[Test]
    public function loadsAllProbesIfFilterClassIsProbeInterface(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe3 = StaticProbeStub::class;

        Probes::register($probe3);
        Probes::register($probe1);

        $probes = iterator_to_array(Probes::load(IStaticProbe::class));

        self::assertContains($probe1, $probes);
        self::assertContains($probe3, $probes);
    }

    #[Test]
    public function throwsIfProbeClassIsNotAStaticProbeSubClass(): void
    {
        $probe = stdClass::class;
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "' .
            $probe .
            '" must be a subclass of "' .
            IStaticProbe::class .
            '" interface.'
        );
        Probes::register($probe);
        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfFilterClassIsNotAStaticProbeSubClass(): void
    {
        $filterClass = stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "' .
            $filterClass .
            '" must be a subclass of "' .
            IStaticProbe::class .
            '" interface.'
        );

        Probes::register(RevoltLoopProbe::class);

        iterator_to_array(Probes::load($filterClass));

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfProbeClassToUnregisterIsNotAStaticProbeSubClass(): void
    {
        $class = stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "' .
            $class .
            '" must be a subclass of "' .
            IStaticProbe::class .
            '" interface.'
        );

        Probes::unregister($class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfInterfaceToUnregisterIsNotAStaticProbeSubClass(): void
    {
        $class = DummyInterfaceStub::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "' .
            $class .
            '" must be a subclass of "' .
            IStaticProbe::class .
            '" interface.'
        );

        Probes::unregister($class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfProbeClassIsNotAStaticProbeSubClass2(): void
    {
        $probe = '';
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Class "' .
            $probe .
            '" must be a subclass of "' .
            IStaticProbe::class .
            '" interface.'
        );
        Probes::register($probe);
        self::fail('Exception was not thrown.');
    }

    protected function setUp(): void
    {
        $this->probes = self::getPropertyValue(Probes::class, self::PROBES);
        $this->setProbes([]);
    }

    protected function setProbes(array $probes): void
    {
        self::setPropertyValue(Probes::class, self::PROBES, $probes);
    }

    protected function tearDown(): void
    {
        $this->setProbes($this->probes);
    }
}
