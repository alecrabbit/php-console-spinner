<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;


use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

final class WidgetConfig implements IWidgetConfig
{
    public function __construct(
        protected ?IRevolver $styleRevolver,
        protected ?IRevolver $charRevolver,
        protected ?IPattern $stylePattern,
        protected ?IPattern $charPattern,
        protected ?IFrame $leadingSpacer,
        protected ?IFrame $trailingSpacer
    ) {
    }
}