<?php
namespace AHT\BirthdayCustomer\Controller\Birthday;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $_customerCollectionFactory;

    /**
     * @param \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $_dateTime;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        array $data = []
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->_dateTime = $dateTime;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $date = $this->_dateTime->gmtDate('m-d');

        try{
            $collections = $this->_customerCollectionFactory->create();

            $collections->addFieldToFilter('dob', array('like'=>'%'.$date.'%'));
            
            foreach ($collections as $value) {
                var_dump($value->getData());
            }

        }catch (\Exception $e) {
            return null;
        }

    }
}
