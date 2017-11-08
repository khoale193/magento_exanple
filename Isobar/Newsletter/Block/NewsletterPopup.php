<?php
namespace Isobar\Newsletter\Block;

use Magento\Newsletter\Block\Subscribe;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;

class NewsletterPopup extends Subscribe
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * Subscriber factory
     *
     * @var SubscriberFactory
     */
    protected $subscriberFactory;

    /**
     * NewsletterPopup constructor.
     *
     * @param Context $context
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        SubscriberFactory $subscriberFactory
    )
    {
        $this->session = $customerSession;
        $this->subscriberFactory = $subscriberFactory;
        parent::__construct($context);
    }

    /**
     * Check current user have subscribed
     *
     * @return bool
     */
    public function isShowPopup()
    {
        if ($this->session->isLoggedIn()) {
            $customerId = $this->session->getCustomerId();
            // Check logged in customer have subscribed
            $customerSubscriber = $this->subscriberFactory->create()->loadByCustomerId($customerId);

            if ($customerSubscriber->getId()) {
                return false;
            }
        }

        return true;
    }
}