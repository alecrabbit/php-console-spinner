<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Contract\IStaticProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Probes;
use AlecRabbit\Tests\Functional\Spinner\Override\StaticProbeOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ProbesTest extends TestCase
{
    private array $probes = [];

//    #[Test]
//    public function canNotBeInstantiated(): void
//    {
//        $this->expectException(\Error::class);
//        $this->expectExceptionMessage('Call to private AlecRabbit\Spinner\Probes::__construct()');
//        $probe = new Probes();
//    }

    #[Test]
    public function canRegisterProbe(): void
    {
        $probe = RevoltLoopProbe::class;
        Probes::register($probe);

        $probes = self::getPropertyValue('probes', Probes::class);
        self::assertContains($probe, $probes);
    }

    #[Test]
    public function canLoadAllProbes(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = StaticProbeOverride::class;

        Probes::register($probe2);
        Probes::register($probe1);

        $probes = iterator_to_array(Probes::load());
        
        self::assertCount(2, $probes);
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
    }

    #[Test]
    public function canRegisterMultipleProbes(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeOverride::class;

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
        $probe3 = StaticProbeOverride::class;

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
        $probe3 = StaticProbeOverride::class;

        Probes::register($probe2);
        Probes::register($probe1);
        Probes::register($probe3);

        $probes = iterator_to_array(Probes::load(ILoopProbe::class));
        self::assertContains($probe1, $probes);
        self::assertContains($probe2, $probes);
        self::assertNotContains($probe3, $probes);
    }

    #[Test]
    public function canUnregisterSpecificProbe(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeOverride::class;

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
    public function unregisteringNonRegisteredProbeHasNoEffect(): void
    {
        $probe1 = ReactLoopProbe::class;
        $probe2 = RevoltLoopProbe::class;
        $probe3 = StaticProbeOverride::class;

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
        $probe3 = StaticProbeOverride::class;

        Probes::register($probe3);
        Probes::register($probe1);

        $probes = iterator_to_array(Probes::load());
        self::assertContains($probe1, $probes);
        self::assertContains($probe3, $probes);
    }

    #[Test]
    public function throwsIfProbeClassIsNotAStaticProbeSubClass(): void
    {
        $probe = stdClass::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $probe .
            '" must implement "' .
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

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $filterClass .
            '" must implement "' .
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

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $class .
            '" must implement "' .
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
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $probe .
            '" must implement "' .
            IStaticProbe::class .
            '" interface.'
        );
        Probes::register($probe);
        self::fail('Exception was not thrown.');
    }

    protected function setUp(): void
    {
        $this->probes = self::getPropertyValue('probes', Probes::class);
        self::setPropertyValue(Probes::class, 'probes', []);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Probes::class, 'probes', $this->probes);
    }
}
