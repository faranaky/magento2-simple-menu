<?php
namespace Fary\SimpleMenu\Model\Config\Source;

class AttributeTypes extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        return [ ['value' => 'filterable', 'label' => 'Filterable'], ['value' => 'searchable', 'label' => 'Searchable'] ];
    }
}