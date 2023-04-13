<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Generator;
use Stringable;
use Traversable;

abstract class AFrameCollectionRenderer implements IFrameCollectionRenderer
{

}
