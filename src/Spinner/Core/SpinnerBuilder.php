<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;

final class SpinnerBuilder implements ISpinnerBuilder
{
    protected ?IConfig $config = null;

    public function __construct(protected IContainer $container)
    {
    }
    
    public function build(): ISpinner
    {
        $this->config = $this->refineConfig($this->config);

        return new class() extends ASpinner {
        };
    }

    public function withConfig(?IConfig $config = null): self
    {
        $clone = clone $this;
        $clone->config = $config;
        return $clone;
    }

    protected function refineConfig(?IConfig $config): IConfig
    {
        return $config;
    }
}