<?php
namespace Fary\SimpleMenu\Model\Config\Source;

class AttributeList extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    protected $attributeFactory;
    /**
     * AttributeList constructor.
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory
     */
    public function __construct(\Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory)
    {
        $this->attributeFactory = $attributeFactory;
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $joinCondition = 'main_table.attribute_id = c.attribute_id';

        $attributeInfo = $this->attributeFactory->getCollection();

        $attributeInfo->join(['c' => $attributeInfo->getTable('catalog_eav_attribute')], $joinCondition, [] );

        $attributeInfo->getSelect()->where('c.is_filterable=1');

        $options = [];
        foreach($attributeInfo as $attribute)
        {
            $options[] = ['value' => $attribute->getAttributeCode(), 'label' => $attribute->getStoreLabel() . ' ('. $attribute->getName() .')'];
        }
        return $options;
    }

}