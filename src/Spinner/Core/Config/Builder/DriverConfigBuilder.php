<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IDriverConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\DriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class DriverConfigBuilder implements IDriverConfigBuilder
{
    private ?IDriverMessages $driverMessages = null;

    /**
     * @inheritDoc
     */
    public function build(): IDriverConfig
    {
        $this->validate();

        return
            new DriverConfig(
                driverMessages: $this->driverMessages,
            );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->driverMessages === null => throw new LogicException('DriverMessages is not set.'),
            default => null,
        };
    }

    public function withDriverMessages(IDriverMessages $driverMessages): IDriverConfigBuilder
    {
        $clone = clone $this;
        $clone->driverMessages = $driverMessages;
        return $clone;
    }
}
