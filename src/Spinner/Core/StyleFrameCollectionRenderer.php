<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Color\Style\Style;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

final class StyleFrameCollectionRenderer extends AFrameCollectionRenderer implements IStyleFrameCollectionRenderer
{
    public function __construct(
        protected IStyleFrameRenderer $frameRenderer,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function createFrame(string|IStyle $entry): IFrame
    {
        if (is_string($entry)) {
            $entry = new Style(fgColor: $entry);
        }
        return $this->frameRenderer->render($entry);
    }

//    /**
//     * @throws InvalidArgumentException
//     */
//    private function createNoStyleCollection(): FrameCollection
//    {
//        return
//            $this->createCollection(
//                new ArrayObject([
//                    $this->frameRenderer->emptyFrame(),
//                ])
//            );
//    }
//
//    /** @inheritdoc */
//    public function render(): IFrameCollection
//    {
////        if ($this->frameRenderer->isStylingDisabled()) {
////            return
////                $this->createNoStyleCollection();
////        }
//        return parent::render();
//    }
}
