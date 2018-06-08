<?php
namespace Fary\SimpleMenu\Model\Config\Source;

class Categories implements \Magento\Framework\Option\ArrayInterface
{
    protected $_attributeFactory;

    protected $categoryFactory;

    /**
     * AttributeList constructor.
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory
     */
    public function __construct(\Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
                                \Magento\Catalog\Model\ResourceModel\Category\Collection $categoryCollectionFactory)
    {
        $this->_attributeFactory = $attributeFactory;
        $this->categoryFactory = $categoryCollectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->categoryFactory->addAttributeToSelect('*');
        $collection->addFieldToFilter([ ['attribute' => 'navigation_type', 'eq' => 'attribute'] , ['attribute' => 'navigation_type', 'eq' => 'bucket'] ] );
        $collection->getSelect()->where('e.parent_id != 1');
        $options = [];
        foreach($collection as $category)
        {
            $options[] = ['value' => $category->getUrl(), 'label' => $category->getName()];
        }
        return $options;
    }
}