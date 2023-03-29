<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IContainer;

final class SpinnerBuilder extends AContainerAware
{

    protected IContainer $container;

    public function __construct(IContainer $container = null)
    {
        $this->container = $container ?? self::getContainer();
    }
}