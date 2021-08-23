<?php
namespace AHT\BirthdayCustomer\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;

    /**
     * @param \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $_dateTime;

    /**
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $_customerCollectionFactory;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->_dateTime = $dateTime;
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->logger = $context->getLogger();
    }

    public function sendEmail()
    {
        $templateId = $this->scopeConfig->getValue('aht/birthday/template', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $fromEmail = $this->scopeConfig->getValue('aht/birthday/email_sender', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $contentEmail = $this->scopeConfig->getValue('aht/birthday/email_content', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('vuna'),
                'email' => $this->escaper->escapeHtml($fromEmail),
            ];

            if (!empty($this->getCustomer())) {
                $receiver = $this->getCustomer();

                foreach ($receiver as $item) {
                    $transport = $this->transportBuilder
                        ->setTemplateIdentifier($templateId)
                        ->setTemplateOptions(
                            [
                                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                            ]
                        )
                        ->setTemplateVars([ 
                            'templateVar'  => $contentEmail,
                            'fullName'     => $item->getData('lastname') . ' ' . $item->getData('firstname')
                        ])
                        ->setFrom($sender)
                        ->addTo($item->getEmail())
                        ->getTransport();
                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                }

            } else {
                return true;
            }

        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    public function getCustomer () 
    {
        $date = $this->_dateTime->gmtDate('m-d');

        try{
            $collections = $this->_customerCollectionFactory->create();

            $collections->addFieldToFilter('dob', array('like'=>'%'.$date.'%'));
            
            // foreach ($collections as $value) {
            //    return $value->getData();
            // }
            return $collections;

        }catch (\Exception $e) {
            return null;
        }

        return true;
    }
}