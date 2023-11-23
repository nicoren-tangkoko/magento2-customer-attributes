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

class CachedMetadata
{

    /**
     *
     * @var Config
     */
    protected Config $config;

    protected string $entityType = "none";


    /**
     *
     * @param Config $config
     * @param string $entityType
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     *
     * @param Subject $subject
     * @param \Magento\Customer\Model\Data\AttributeMetadata[] $attributesMetadata
     * @return void
     */
    public function afterGetAttributes(Subject $subject, $attributesMetadata, $formCode)
    {
        $attributes = $this->config->getEntityAttributes($this->entityType);
        foreach ($attributesMetadata as $item) {
            if (isset($attributes[$item->getAttributeCode()])) {
                $attribute = $attributes[$item->getAttributeCode()];
                $camAttribute = $attribute->getExtensionAttributes()->getCamAttribute();
                if ($camAttribute && (count($camAttribute->getRequiredConditions()->getConditions()) > 0 || count($camAttribute->getVisibilityConditions()->getConditions()) > 0)) {
                    $item->setIsRequired(false);
                    $item->setFrontendClass("");
                }
            }
        }
        return $attributesMetadata;
    }
}
