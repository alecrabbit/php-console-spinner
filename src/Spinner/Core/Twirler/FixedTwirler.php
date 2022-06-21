<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Twirler;

use AlecRabbit\Spinner\Core\Revolver\Contract\ICharRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleRevolver;
use AlecRabbit\Spinner\Core\Twirler\Contract\ATwirler;
use AlecRabbit\Spinner\Core\Twirler\Contract\ITwirlerFrame;

final class FixedTwirler extends ATwirler
{
    public function __construct(IStyleRevolver $styleRevolver, ICharRevolver $charRevolver)
    {
        parent::__construct($styleRevolver, $charRevolver);
        $this->currentFrame = $this->render();
    }

    public function render(): ITwirlerFrame
    {
        return $this->currentFrame;
    }

}
