<?php
namespace Fary\SimpleMenu\Model\Config\Source;


class YesNo extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        return [ ['value' => 0, 'label' => 'No'], ['value' => 1, 'label' => 'Yes'] ];
    }
}