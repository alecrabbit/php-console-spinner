<?php
declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Kernel\Config\Contract\IConfig;
use AlecRabbit\Spinner\Kernel\Contract\ABaseSpinner;
use AlecRabbit\Spinner\Kernel\Contract\CanAddTwirler;
use AlecRabbit\Spinner\Kernel\Contract\IMultiSpinner;
use AlecRabbit\Spinner\Kernel\Contract\ITwirler;
use AlecRabbit\Spinner\Kernel\Exception\MethodNotImplementedException;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\WIInterval;

final class MultiSpinner extends ABaseSpinner implements IMultiSpinner
{
    public function __construct(IConfig $config)
    {
        parent::__construct($config);
        $this->container = $config->getTwirlers();
    }

    public function addTwirler(ITwirler $twirler): CanAddTwirler
    {
        // FIXME (2022-06-19 19:40) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);
    }

    public function getInterval(): WIInterval
    {
        // FIXME (2022-06-19 19:39) [Alec Rabbit]: Implement this
        throw new MethodNotImplementedException(__METHOD__);
    }
}
