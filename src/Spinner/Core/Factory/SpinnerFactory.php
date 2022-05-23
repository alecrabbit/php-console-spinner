<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Builder\ConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IRotator;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Rotator;

final class SpinnerFactory implements ISpinnerFactory
{
    private static ?IRotator $spinner = null;

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     */
    public static function get(): IRotator
    {
        if (self::hasSpinnerInstance()) {
            return self::$spinner;
        }
        return self::create();
    }

    private static function hasSpinnerInstance(): bool
    {
        return self::$spinner instanceof IRotator;
    }

    /**
     * @throws DomainException
     * @throws InvalidArgumentException
     */
    public static function create(string|ISpinnerConfig|null $classOrConfig = null): IRotator
    {
        if (self::hasSpinnerInstance()) {
            // There Can Be Only One
            throw new DomainException(
                sprintf('Spinner instance was already created: [%s]', self::$spinner::class)
            );
        }

        $class = self::refineClass($classOrConfig);
        $config = self::refineConfig($classOrConfig);

        $spinner =
            self::doCreate(
                $class,
                $config,
            );

        if ($spinner->isAsynchronous()) {
            self::attachSpinnerToLoop($spinner, $config);
            self::initialize($spinner, $config);
            self::attachSigIntListener($spinner, $config);
        }

        self::setSpinner($spinner);

        return $spinner;
    }

    private static function refineClass(string|ISpinnerConfig|null $classOrConfig): string
    {
        if (is_string($classOrConfig)) {
            return $classOrConfig;
        }
        if ($classOrConfig instanceof ISpinnerConfig) {
            return $classOrConfig->getSpinnerClass();
        }
        return Rotator::class;
    }

    private static function refineConfig(string|ISpinnerConfig|null $config): ISpinnerConfig
    {
        if ($config instanceof ISpinnerConfig) {
            return $config;
        }
        return (new ConfigBuilder())->build();
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function doCreate(string $class, ISpinnerConfig $config): IRotator
    {
        if (is_subclass_of($class, IRotator::class)) {
            return new $class($config);
        }
        throw new InvalidArgumentException(
        // TODO (2022-01-30 11:17) [Alec Rabbit]: clarify message [975f3695-a537-4745-a22b-12b9844e666f]
            sprintf('Unsupported class [%s]', $class)
        );
    }

    private static function attachSpinnerToLoop(
        IRotator $spinner,
        ISpinnerConfig $config
    ): void {
        $config->getLoop()
            ->addPeriodicTimer(
                $spinner->refreshInterval(),
                static function () use ($spinner) {
                    $spinner->rotate();
                }
            );
    }

    private static function initialize(
        IRotator $spinner,
        ISpinnerConfig $config
    ): void {
        $spinner->begin();
    }

    private static function attachSigIntListener(
        IRotator $spinner,
        ISpinnerConfig $config
    ): void {
        if (defined('SIGINT')) { // check for ext-pcntl
            $loop = $config->getLoop();

            $func = static function () use ($loop, &$func, $spinner, $config) {
                $spinner->end();
                $config->getDriver()->getWriter()->getOutput()->write(PHP_EOL . $config->getExitMessage() . PHP_EOL);
                /** @noinspection PhpComposerExtensionStubsInspection */
                $loop->removeSignal(SIGINT, $func);
                $loop->addTimer(
                    $config->getShutdownDelay(),
                    static function () use ($loop) {
                        $loop->stop();
                    }
                );
            };
            /** @noinspection PhpComposerExtensionStubsInspection */
            $loop->addSignal(SIGINT, $func,);
        }
    }

    private static function setSpinner(IRotator $spinner): void
    {
        self::$spinner = $spinner;
    }
}
