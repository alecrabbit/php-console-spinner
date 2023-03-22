<?php

declare(strict_types=1);
// 16.03.23

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilderGetter;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopHelper;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\A\ADefaultsAwareClass;
use AlecRabbit\Spinner\Core\Factory\A\ASpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopGetter;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Helper\Asserter;

final class Facade extends ADefaultsAwareClass implements
    ISpinnerFactory,
    IConfigBuilderGetter,
    ILoopGetter
{
    protected static ?string $loopHelperClass = null;

    public static function getConfigBuilder(): IConfigBuilder
    {
        return
            ASpinnerFactory::getConfigBuilder();
    }

    /**
     * @throws DomainException
     */
    public static function createSpinner(IConfig $config = null): ISpinner
    {
        return
            ASpinnerFactory::createSpinner($config);
    }

    /**
     * @throws DomainException
     */
    public static function getLoop(): ILoopAdapter
    {
        /** @var ILoopHelper $loopHelper */
        $loopHelper = self::getLoopHelper();
        return
            $loopHelper::get();
    }

    /**
     * @throws DomainException
     */
    public static function getLoopHelper(): string
    {
        if (null === self::$loopHelperClass) {
            throw new DomainException('LoopHelper class is not registered');
        }
        return self::$loopHelperClass;
    }

    /**
     * @param class-string $class
     * @throws InvalidArgumentException
     */
    public static function registerLoopHelperClass(string $class): void
    {
        Asserter::assertClassExists($class);
        Asserter::isSubClass($class, ILoopHelper::class);
        self::$loopHelperClass = $class;
    }
}
