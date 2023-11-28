<?php

/**
 * Created on Tue Nov 21 2023
 * @author : Nicolas RENAULT <nrenault@tangkoko.com>
 * @copyright (c) 2023 Tangkoko
 **/

namespace Tangkoko\CustomerAttributesManagement\Plugin\Customer\Model\ResourceModel;

use Magento\Customer\Model\CustomerFactory;
use Tangkoko\CustomerAttributesManagement\Model\Context\WebapiContext;
use Magento\Customer\Api\CustomerRepositoryInterface;


class CustomerRepository
{
    private WebapiContext $context;

    /**
     * @var CustomerFactory
     */
    private CustomerFactory $customerFactory;

    public function __construct(WebapiContext $context, CustomerFactory $customerFactory)
    {
        $this->context = $context;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function beforeSave(CustomerRepositoryInterface $subject, \Magento\Customer\Api\Data\CustomerInterface $customer)
    {
        $customerModel = $this->customerFactory->create()->updateData(
            $customer->setAddresses([])
        );
        $this->context->setCustomer($customerModel);
    }
}
