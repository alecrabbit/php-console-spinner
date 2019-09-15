<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Adapters;

use AlecRabbit\Spinner\Core\Contracts\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\StreamOutput;
use function AlecRabbit\typeOf;

/**
 * Class SymfonyOutputAdapter
 *
 * @codeCoverageIgnore
 */
class SymfonyOutputAdapter extends AbstractOutputAdapter
{
    /** @var StreamOutput */
    protected $output;

    public function __construct(ConsoleOutput $output)
    {
        $streamOutput = $output->getErrorOutput();
        if ($streamOutput instanceof StreamOutput) {
            $this->output = $streamOutput;
        } else {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException(
                'Should never happen. $streamOutput is of wrong type: [' .
                StreamOutput::class . '] expected , ['
                . typeOf($streamOutput) . '] given.'
            );
            // @codeCoverageIgnoreEnd
        }
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
