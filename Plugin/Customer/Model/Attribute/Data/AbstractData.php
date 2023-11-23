<?php

/**
 * Created on Thu Nov 23 2023
 * @author : Nicolas RENAULT <nrenault@tangkoko.com>
 * @copyright (c) 2023 Tangkoko
 **/

namespace Tangkoko\CustomerAttributesManagement\Plugin\Customer\Model\Attribute\Data;

use Magento\Eav\Model\Attribute\Data\AbstractData as Subject;
use Magento\Customer\Model\CustomerFactory;

class AbstractData
{
    private CustomerFactory $customerFactory;

    public function __construct(CustomerFactory $customerFactory)
    {
        $this->customerFactory = $customerFactory;
    }
    public function beforeValidateValue(Subject $subject, $value)
    {
        $attribute =  $subject->getAttribute();
        if ($attribute->getIsRequired() && $attribute->getExtensionAttributes()->getCamAttribute()) {
            $isRequired = $attribute->getExtensionAttributes()->getCamAttribute()->isRequired($this->customerFactory->create([$attribute->getAttributeCode() => $value]));
            $attribute->setCamIsRequired($isRequired);
        }
        return [$value];
    }
}
