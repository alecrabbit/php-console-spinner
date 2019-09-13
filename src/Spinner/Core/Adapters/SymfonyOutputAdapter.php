<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Adapters;

use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface as SymfonyOutput;
use Symfony\Component\Console\Output\OutputInterface as SymfonyOutputInterface;

/**
 * Class SymfonyOutputAdapter
 *
 * @codeCoverageIgnore
 */
class SymfonyOutputAdapter implements OutputInterface
{
    /** @var SymfonyOutputInterface */
    protected $output;

    public function __construct(SymfonyOutput $output)
    {
        $this->output = $output->getErrorOutput();
    }

    /** {@inheritDoc} */
    public function write($messages, $newline = false, $options = 0): void
    {
        $this->output->write($messages, $newline, $options);
    }

    /**
     * @return resource
     */
    public function getStream()
    {
        return $this->output->getStream();
    }
}
