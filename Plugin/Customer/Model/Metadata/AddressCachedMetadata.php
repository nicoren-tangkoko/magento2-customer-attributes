<?php

/**
 * Created on Thu Nov 23 2023
 * @author : Nicolas RENAULT <nrenault@tangkoko.com>
 * @copyright (c) 2023 Tangkoko
 **/

namespace Tangkoko\CustomerAttributesManagement\Plugin\Customer\Model\Metadata;

use Magento\Customer\Model\Metadata\CachedMetadata as Subject;
use Magento\Eav\Model\Config;
use Tangkoko\CustomerAttributesManagement\Model\Data\CamAttributeFactory;

class AddressCachedMetadata extends CachedMetadata
{
    protected string $entityType = "customer_address";
}
