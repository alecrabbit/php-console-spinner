<?php
declare(strict_types=1);
// 20.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrameCollection;
use ArrayObject;
use Traversable;

final class FrameCollection extends ArrayObject implements IFrameCollection
{
    public function __construct(Traversable $frames)
    {
        parent::__construct($frames);
    }
}
