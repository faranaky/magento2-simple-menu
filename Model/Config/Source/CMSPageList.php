<?php
namespace Fary\SimpleMenu\Model\Config\Source;


class CMSPageList extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    protected $pageFactory;

    protected $pageHelper;

    public function __construct(\Magento\Cms\Model\PageFactory $pageFactory, \Magento\Cms\Helper\Page $pageHelper)
    {
        $this->pageFactory = $pageFactory;

        $this->pageHelper = $pageHelper;
    }

    public function getAllOptions($withEmpty = true)
    {
        $page = $this->pageFactory->create();

        $options = [];

        foreach($page->getCollection() as $item)
        {
            //$link = $this->pageHelper->getPageUrl($item->getIdentifier());
            $options[] = ['value' => $item->getId(), 'label' => $item->getTitle()];
        }

        return $options;
    }

}