<?php

namespace Tangkoko\CustomerAttributesManagement\Plugin\Checkout\Block;

use Magento\Customer\Model\AttributeMetadataDataProvider;
use Magento\Customer\Model\Session;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

class LayoutProcessor
{

    private AttributeMetadataDataProvider $attributeMetadataDataProvider;
    private CheckoutSession $session;

    public function __construct(
        AttributeMetadataDataProvider $attributeMetadataDataProvider,
        CheckoutSession $session

    ) {
        $this->attributeMetadataDataProvider = $attributeMetadataDataProvider;
        $this->session = $session;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,

        array  $jsLayout
    ) {
        /** @var AttributeInterface[] $attributes */
        $attributes = $this->attributeMetadataDataProvider->loadAttributesCollection(
            'customer_address',
            'customer_register_address'
        );

        foreach ($attributes as $attribute) {
            if (
                isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress'])
                && isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$attribute->getAttributeCode()])
                && $attribute->getExtensionAttributes()->getCamAttribute()
            ) {

                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$attribute->getAttributeCode()]["visible"] =
                    $attribute->getExtensionAttributes()->getCamAttribute()->isVisible($this->session->getQuote()->getShippingAddress());
            }
        }
        return $jsLayout;
    }
}
