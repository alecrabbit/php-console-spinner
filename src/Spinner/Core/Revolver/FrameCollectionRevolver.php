<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Revolver\A\AFrameCollectionRevolver;

/**
 * @template T of IFrame
 * @template-extends AFrameCollectionRevolver<T>
 */
final class FrameCollectionRevolver extends AFrameCollectionRevolver
{
}
