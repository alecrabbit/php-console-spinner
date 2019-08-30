<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Adapters;

use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use Symfony\Component\Console\Output\OutputInterface as SymfonyOutput;

/**
 * Class SymfonyOutputAdapter
 *
 * @codeCoverageIgnore
 */
class SymfonyOutputAdapter implements OutputInterface
{
    /** @var SymfonyOutput */
    protected $output;

    public function __construct(SymfonyOutput $output)
    {
        $this->output = $output;
    }

    /** {@inheritDoc} */
    public function write($messages, $newline = false, $options = 0): void
    {
        $this->output->write($messages, $newline, $options);
    }
}
