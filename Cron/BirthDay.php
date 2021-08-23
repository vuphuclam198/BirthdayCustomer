<?php
namespace AHT\BirthdayCustomer\Cron;

class BirthDay
{
   /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    protected $logger;

    /**
     * @param \Xigen\BackInStock\Helper\Data $helper
     */
    protected $_helper;

    /**
     * Constructor
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Xigen\BackInStock\Helper\Data $helper
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \AHT\BirthdayCustomer\Helper\Email $helper
    ) {
        $this->logger = $logger;
        $this->_helper = $helper;
    }

    /**
     * Execute the cron
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob Back In Stock is executed.");
        $this->_helper->sendEmail();
        $this->logger->addInfo("Cronjob Back In Stock is finished.");
    }
}
