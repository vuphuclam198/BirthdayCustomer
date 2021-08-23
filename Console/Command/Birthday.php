<?php

namespace AHT\BirthdayCustomer\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Birthday extends Command
{
    /**
     * @param \AHT\BirthdayCustomer\Helper\Email
     */
    private $_helper;

    public function __construct(
        \AHT\BirthdayCustomer\Helper\Email $helper
    ) 
    {
        $this->_helper = $helper;
        return parent::__construct();
        
    }

    protected function configure()
    {
        $this->setName('magento:birthday');
        $this->setDescription('Demo command line');
        
        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello World");
        return $this->_helper->sendEmail();

    }
}