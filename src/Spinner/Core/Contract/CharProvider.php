<?php

declare(strict_types=1);
// 21.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Defaults;
use AlecRabbit\Spinner\Core\Frame\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Spinner\Core\Interval\Interval;
use AlecRabbit\Spinner\Core\WidthDefiner;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;

final class CharProvider implements ICharProvider
{
    public function __construct(
        protected readonly ICharFrameFactory $charFactory,
        protected readonly ICharPatternExtractor $extractor,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[ArrayShape([C::FRAMES => "array", C::INTERVAL => Interval::class])]
    public function provide(array $charPattern = null): array
    {
        $charPattern = $charPattern ?? $this->getDefaultCharPattern();

        $extracted = $this->extractor->extract($charPattern);

        $frames = $extracted[C::CHARS][C::FRAMES];
        $width = $extracted[C::CHARS][C::WIDTH];
        $interval = $extracted[C::CHARS][C::INTERVAL];

        $chars = [];
        foreach ($frames as $char) {
            $chars[] =
                $this->charFactory->create($char, $width ?? WidthDefiner::define($char));
        }
        return
            [
                C::FRAMES => $chars,
                C::INTERVAL => new Interval($interval),
            ];
    }

    private function getDefaultCharPattern(): array
    {
        return Defaults::getDefaultCharPattern();
    }
}
