<?php
namespace Fary\SimpleMenu\Model\Config\Source;

class Attributes implements \Magento\Framework\Option\ArrayInterface
{
    protected $_attributeFactory;

    /**
     * AttributeList constructor.
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory
     */
    public function __construct(\Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory)
    {
        $this->_attributeFactory = $attributeFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $joinCondition = 'main_table.attribute_id = c.attribute_id';
        $attributeInfo = $this->_attributeFactory->getCollection();
        $attributeInfo->addFieldToFilter('frontend_input', 'select');
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