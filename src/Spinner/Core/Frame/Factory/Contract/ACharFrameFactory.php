<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Frame\CharFrame;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\WidthDefiner;

abstract class ACharFrameFactory implements ICharFrameFactory
{
    public function create(string|ICharFrame $char, ?int $width = null): ICharFrame
    {
        if ($char instanceof ICharFrame) {
            return $char;
        }

        return
            new CharFrame(
                $char,
                $width ?? WidthDefiner::define($char)
            );
    }

//    public function create(mixed $item, ?string $format): IStyleFrame
//    {
//        if($item instanceof IStyleFrame) {
//            return $item;
//        }
//
//        if (is_scalar($item)) {
//            $item = [$item];
//        }
//
//        return
//            new StyleFrame(
//                Sequencer::colorSequenceStart(sprintf($format, ...$item)),
//                Sequencer::colorSequenceEnd()
//            );
//
    }
