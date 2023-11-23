<?php

/**
 * Created on Thu Nov 23 2023
 * @author : Nicolas RENAULT <nrenault@tangkoko.com>
 * @copyright (c) 2023 Tangkoko
 **/

namespace Tangkoko\CustomerAttributesManagement\Plugin\Eav\Model;

use Tangkoko\CustomerAttributesManagement\Model\ResourceModel\CamAttribute\CollectionFactory;
use Magento\Eav\Model\Config as Subject;

class Config
{
    /**
     *
     * @var CollectionFactory
     */
    private $collectionFactory;


    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function afterGetEntityAttributes(Subject $subject, $result)
    {

        $ids = [];

        foreach ($result as $attribute) {
            $ids[] = $attribute->getAttributeId();
        }

        /**
         * @var \Tangkoko\CustomerAttributesManagement\Model\ResourceModel\CamAttribute\Collection $collection
         */
        $collection = $this->collectionFactory->create()->addFieldToFilter("attribute_id", ["in" => $ids]);

        foreach ($result as $item) {

            /**
             * @var \Magento\EAv\Model\Attribute $item
             */
            if ($camAttribute = $collection->getItemById($item->getAttributeId())) {
                $camAttribute->setAttribute($item);
                $item->getExtensionAttributes()->setCamAttribute($camAttribute);
            }
        }
        return $result;
    }
}
