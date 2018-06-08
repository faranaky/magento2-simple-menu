<?php
namespace Fary\SimpleMenu\Model\Config\Source;

class NavigationTypeList extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions($withEmpty = true)
    {
        $options = ['bucket' => 'Category', 'attribute' => 'Attribute', 'cms_page' => 'CMS Page', 'link' => 'Link'];

        foreach ($options as $key => $value)
        {
            $list[] = ['value' => $key, 'label' => $value];
        }

        return $this->_options = $list;
    }

}