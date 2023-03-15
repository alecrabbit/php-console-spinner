<?php

declare(strict_types=1);

namespace Example\Kernel\A;

use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Factory\DefaultsFactory;
use AlecRabbit\Spinner\Core\Output\StreamOutput;
use AlecRabbit\Spinner\Factory;
use Closure;
use Example\Kernel\AppConfig;
use Example\Kernel\Benchmark;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use InvalidArgumentException;

abstract class AbstractApp
{
    public const MICROSECONDS_COEFFICIENT = 1000000;
    protected const INTERVAL = 'interval';
    protected const CALLBACK = 'callback';

    public readonly AppConfig $applicationConfig;
    public readonly ISpinner $spinner;
    public readonly Closure $writeln;
    public readonly Closure $write;
    public readonly Closure $writelnErr;
    public readonly Closure $writeErr;
    public readonly FakerGenerator $faker;
    protected readonly Benchmark $benchmark;
    protected int $cycle;
    protected int $timeLimit;
    protected int $progressTimeLimit;
    protected int $progressAdvanceInterval;
    protected int $benchmarkMessageDelay;
    protected int $benchmarkMessageInterval;
    protected int $spinInterval;
    protected bool $initialized = false;
    protected bool $limitRunTime = true;
    protected int $optionalInterval;
    protected array $callbacks = [];

    public function __construct(
        ?AppConfig $appConfig = null,
        ?IConfig $spinnerConfig = null,
    ) {
        $this->benchmark = new Benchmark();
        $this->applicationConfig = $appConfig ?? new AppConfig();
        $this->faker = FakerFactory::create();
        $this->assertSpinnerConfig($spinnerConfig);
//        self::prepareDefaults();
        $this->initialize($spinnerConfig);
    }

    protected function assertSpinnerConfig(?IConfig $config): void
    {
        if (null === $config) {
            $this->tuneDefaults();
            return;
        }
        if ($config->isAsynchronous()) {
            throw new InvalidArgumentException(
                'Asynchronous mode is not supported in this example.'
            );
        }
    }

    protected function tuneDefaults(): void
    {
        $defaults = DefaultsFactory::get();
        if (!$defaults->isModeSynchronous()) {
            $defaults->setModeAsSynchronous(true);
        }
    }

    public function initialize(?IConfig $config = null): void
    {
        $this->calculateAppTimeVariables();

        $this->spinner = Factory::createSpinner($config);

        $stdout = new StreamOutput(STDOUT);
        $stderr = new StreamOutput(STDERR);
        $this->write = $stdout->write(...);
        $this->writeln = $stdout->writeln(...);
        $this->writeErr = $stderr->write(...);
        $this->writelnErr = $stderr->writeln(...);

        $this->spinInterval = (int)$this->spinner->getInterval()->toMicroseconds();

        $this->initializeAuxiliary();

        $this->spinner->initialize();

        $this->initialized = true;
    }

    protected function calculateAppTimeVariables(): void
    {
        $this->cycle = (int)($this->applicationConfig->cycleLength * self::MICROSECONDS_COEFFICIENT); // 10 ms
        $this->timeLimit = $this->applicationConfig->mainRunTime * self::MICROSECONDS_COEFFICIENT;

        $this->progressTimeLimit = $this->applicationConfig->progressRunTime * self::MICROSECONDS_COEFFICIENT;
        $this->progressAdvanceInterval = (int)($this->progressTimeLimit / $this->applicationConfig->progressSteps);

        $this->optionalInterval = (int)($this->applicationConfig->optionalInterval * self::MICROSECONDS_COEFFICIENT);

        $this->benchmarkMessageDelay = $this->applicationConfig->messageDelay * self::MICROSECONDS_COEFFICIENT;
        $this->benchmarkMessageInterval = $this->applicationConfig->messageInterval * self::MICROSECONDS_COEFFICIENT;
    }

    protected function initializeAuxiliary(): void
    {
        // override if needed
    }

    public static function prepareDefaults(): void
    {
        DefaultsFactory::get()
            ->setModeAsSynchronous(true);
    }

    public function run(): void
    {
        $this->start();

        $this->main();

        $this->finish();
    }

    protected function start(): void
    {
        if (!$this->initialized) {
            $this->initialize();
        }
    }

    protected function main(): void
    {
        $this->mainLoop();

        $this->additionalLoop();
    }

    protected function mainLoop(): void
    {
        $this->spinner->wrap(
            $this->writelnErr,
            sprintf(
                'Main loop: %ss',
                $this->applicationConfig->mainRunTime
            ),
        );

        $elapsed = 0;

        while (true) {
            if ($this->limitRunTime && $elapsed > $this->timeLimit) {
                break;
            }
            if ($elapsed % $this->spinInterval === 0) {
                $start = hrtime(true);
                $this->spinner->spin();
                $this->benchmark->add(hrtime(true) - $start);
            }

            foreach ($this->callbacks as $callback) {
                if ($elapsed % $callback[self::INTERVAL] === 0) {
                    ($callback[self::CALLBACK])($this);
                }
            }

            if ($elapsed > $this->benchmarkMessageDelay
                && $elapsed % $this->benchmarkMessageInterval === 0) {
                $this->spinner->wrap(
                    $this->writelnErr,
                    $this->benchmark->report(),
                );
            }

            usleep($this->cycle);
            $elapsed += $this->cycle;
        }
    }

    protected function additionalLoop(): void
    {
        $this->spinner->wrap(
            $this->writelnErr,
            sprintf(
                'Additional loop: %ss',
                $this->applicationConfig->additionalRunTime
            ),
        );

        $elapsed = 0;
        $timeLimit = $this->applicationConfig->additionalRunTime * self::MICROSECONDS_COEFFICIENT;

        while ($elapsed < $timeLimit) {
            if ($elapsed % $this->spinInterval === 0) {
                $this->spinner->spin();
            }

            usleep($this->cycle);
            $elapsed += $this->cycle;
        }
    }

    protected function finish(): void
    {
        $this->spinner->finalize();
    }

    public function addCallback(Closure $closure, float $interval): void
    {
        $this->callbacks[] = [
            self::CALLBACK => $closure,
            self::INTERVAL => (int)($interval * self::MICROSECONDS_COEFFICIENT),
        ];
    }
}
