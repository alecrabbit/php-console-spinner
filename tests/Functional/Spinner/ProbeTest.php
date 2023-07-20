<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Asynchronous\Loop\Probe\ReactLoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\RevoltLoopProbe;
use AlecRabbit\Spinner\Contract\IStaticProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Probe;
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

    protected function setUp(): void
    {
        $this->probes = self::getPropertyValue('probes', Probe::class);
        self::setPropertyValue(Probe::class, 'probes', []);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Probe::class, 'probes', $this->probes);
    }


//    #[Test]
//    public function returnsLoopProbeFactory(): void
//    {
//        $container = $this->getTesteeInstance();
//
//        $result = $container->get(ILoopProbeFactory::class);
//
//        self::assertInstanceOf(LoopProbeFactory::class, $result);
//    }

//    public function getTesteeInstance(
//        ?string $class = null,
//        ?IDefinitionRegistry $registry = null,
//    ): IContainer {
//        $class ??= ContainerFactory::class;
//
//        $registry ??= DefinitionRegistry::getInstance();
//
//        $factory = new $class($registry);
//        return self::callMethod($factory, 'createContainer');
//    }
}
