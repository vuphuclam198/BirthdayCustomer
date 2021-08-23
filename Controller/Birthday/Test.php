<?php
namespace AHT\BirthdayCustomer\Controller\Birthday;

class Test extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_helper;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \AHT\BirthdayCustomer\Helper\Email $helper,
       \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_helper = $helper;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
         $this->_helper->sendEmail();
         die("ok");
    }
}
