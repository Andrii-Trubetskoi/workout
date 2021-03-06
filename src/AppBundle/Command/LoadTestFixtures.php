<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class LoadTestFixtures extends Command
{
    /**
     * @var \AppKernel
     */
    private $kernel;

    /**
     * @var string
     */
    private $defaultPath;

    /**
     * @var string
     */
    private $testDbPath;

    /**
     * @return \AppKernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @param \AppKernel $kernel
     */
    public function setKernel($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return string
     */
    public function getDefaultPath()
    {
        return $this->defaultPath;
    }

    /**
     * @param string $defaultPath
     */
    public function setDefaultPath($defaultPath)
    {
        $this->defaultPath = $defaultPath;
    }

    /**
     * @return string
     */
    public function getTestDbPath()
    {
        return $this->testDbPath;
    }

    /**
     * @param string $testDbPath
     */
    public function setTestDbPath($testDbPath)
    {
        $this->testDbPath = $testDbPath;
    }

    protected function configure()
    {
        $this
            ->setName('load:test:fixtures')
            ->setDescription('Create DB with data for tests.')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force upgrade fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();

        if ($input->getOption('force') || !$fs->exists($this->getDefaultPath())) {
            $application = new Application($this->getKernel());
            $application->setAutoExit(false);
            $arguments = ['command' => 'd:s:u', '--force' => true, '-e' => 'test'];
            $in = new ArrayInput($arguments);
            $out = new BufferedOutput();
            $application->run($in, $out);
            $output->writeln($out->fetch());

            $arguments = ['command' => 'h:d:f:l', '--no-interaction' => true, '-e' => 'test'];
            $in = new ArrayInput($arguments);
            $out = new BufferedOutput();
            $application->run($in, $out);
            $output->writeln($out->fetch());

            if ($fs->exists($this->getTestDbPath())) {
                $fs->copy($this->getTestDbPath(), $this->getDefaultPath());
            }
        }

        $output->writeln('Done.');
    }
}
