<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Benchmark\Contract\Builder\IReportPrinterBuilder;
use AlecRabbit\Benchmark\Contract\Factory\IReportPrinterFactory;
use AlecRabbit\Benchmark\Contract\IReportFormatter;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Benchmark\Factory\ReportPrinterFactory;
use AlecRabbit\Benchmark\ReportPrinter;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Output\Output;

final class BenchmarkReportPrinterFactory implements IReportPrinterFactory, IInvokable
{
    public function __construct(
        protected IReportPrinterBuilder $builder,
        protected IReportFormatter $reportFormatter,
    ) {
    }

    public function __invoke(): IReportPrinter
    {
        return $this->create();
    }

    public function create(): IReportPrinter
    {
        return $this->builder
            ->withOutput($this->getOutput())
            ->withReportFormatter($this->reportFormatter)
            ->build()
        ;
    }

    private function getOutput(): IOutput
    {
        $stream = new class() implements IWritableStream {
            public function write(\Traversable $data): void
            {
                foreach ($data as $el) {
                    echo $el;
                }
            }
        };
        return new Output($stream);
    }
}
