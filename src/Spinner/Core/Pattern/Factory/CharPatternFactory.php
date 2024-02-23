<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IHasFrameWrapper;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Contract\IUpdateChecker;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\CharPattern;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;
use AlecRabbit\Spinner\Core\UpdateChecker;

final readonly class CharPatternFactory implements ICharPatternFactory
{
    public function __construct(
        private IIntervalFactory $intervalFactory,
        private ICharFrameTransformer $transformer,
        private IRevolverConfig $revolverConfig,
    ) {
    }

    public function create(IPalette $palette): ICharPattern
    {
        $interval = $this->intervalFactory->createNormalized(
            $palette->getOptions()->getInterval()
        );

        $frames = $this->wrap($palette, $interval);

        return new CharPattern(
            frames: $frames,
            interval: $interval,
        );
    }

    private function wrap(IPalette $palette, IInterval $interval): IHasCharSequenceFrame
    {
        $updateChecker = new UpdateChecker(
            $interval->toMilliseconds(),
            $this->revolverConfig->getTolerance()->toMilliseconds(),
        );

        return new class(
            $palette,
            $this->transformer,
            $updateChecker,
        ) implements IHasCharSequenceFrame {
            private IFrame $currentFrame;

            public function __construct(
                private readonly IHasFrame $frames,
                private readonly ICharFrameTransformer $transformer,
                private readonly IUpdateChecker $updateChecker,
            ) {
                $this->currentFrame = $this->getFrame();
            }

            public function getFrame(?float $dt = null): ICharSequenceFrame
            {
                if ($this->updateChecker->isDue($dt)) {
                    $this->currentFrame = $this->nextFrame($dt);
                }
                return $this->currentFrame;
            }

            private function nextFrame(?float $dt = null): ICharSequenceFrame
            {
                return $this->transformer->transform(
                    $this->frames->getFrame($dt)
                );
            }
        };
    }
}
