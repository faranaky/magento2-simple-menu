<?php

namespace Fary\SimpleMenu\Block\Adminhtml\Options;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Template;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

class Options extends Template implements RendererInterface
{

    protected $directoryList;
    protected $developerMode;
    protected $storeManager;
    protected $scopeConfig;
    protected $themeProvider;
    protected $template;
    protected $context;

    public function __construct(Template\Context $context,
                                array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function _toHtml()
    {
        $this->setTemplate('options/options.phtml');
        return parent::_toHtml();
    }

    public function render(AbstractElement $element)
    {
        $html = $this->toHtml();
        return $html;
    }

    public function getMediaUrl() {
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $_objectManager->get('Magento\Store\Model\StoreManagerInterface');
        $currentStore = $storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }

}