<?php

namespace Fary\SimpleMenu\Block\Html;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
    protected $eavConfig;

    protected $categoryArray;

    protected $pageHelper;

    protected $filterProvider;

    public function __construct(Template\Context $context,
                                NodeFactory $nodeFactory,
                                TreeFactory $treeFactory,
                                \Magento\Catalog\Model\Category $categoryArray,
                                \Magento\Eav\Model\Config $eavConfig,
                                \Magento\Cms\Helper\Page $pageHelper,
                                \Magento\Cms\Model\Template\FilterProvider $filterProvider,
                                array $data = [])
    {
        $this->pageHelper = $pageHelper;
        $this->categoryArray = $categoryArray;
        $this->eavConfig = $eavConfig;
        $this->filterProvider = $filterProvider;
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
    }

    protected function content()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $filterProvider = $objectManager->create('\Magento\Cms\Model\Template\FilterProvider');
        $storeManager = $objectManager->create('\Magento\Store\Model\StoreManagerInterface');
        $blockFactory = $objectManager->create('\Magento\Cms\Model\BlockFactory');
        $html = '';
        if ($this->blockId) {
            $storeId = $storeManager->getStore()->getId();
            /** @var \Magento\Cms\Model\Block $block */
            $block = $blockFactory->create();
            $block->setStoreId($storeId)->load($this->blockId);

            $html = $filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent());
        }
        return   $html;
    }


    protected function _getHtml(
        \Magento\Framework\Data\Tree\Node $menuTree,
        $childrenWrapClass,
        $limit,
        array $colBrakes = []
    ) {
        $html = '';

        $children = $menuTree->getChildren();

        $parentLevel = $menuTree->getLevel();
        $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;

        $counter = 1;
        $itemPosition = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        foreach ($children as $child)
        {
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $target = $child->getData('blank_target') ? '_blank' : '_self';

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass)
            {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            if (count($colBrakes) && $colBrakes[$counter]['colbrake'])
            {
                $html .= '</ul></li><li class="column"><ul>';
            }

            $isMegaMenu = $child->getData('is_mega_menu');
            $megaMenu = $isMegaMenu ? 'fary-megamenu ' : '';

            $promoBlock = $this->getWysiwygFilterContent($child->getData('promo_block'));

            $hasPromo = '';
            if (!empty($promoBlock)) {
                $promoBlock = $isMegaMenu ? '<li class="promo">' . $promoBlock . '</li>' : '';
                $hasPromo = 'haspromo';
            }

            if($child->getData('navigation_type') == 'attribute')
            {
                $attributes = $child->getData('mega_menu_attributes');
                $attributes = explode(',', $attributes);

                $noParentClass = count($attributes) == 1 ? 'fary-no-parent ' : '';

                $attributeClass = count($attributes) == 1 ? $attributes[0] . ' ' : '';

                $menuItem = '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>' . '<a target="' . $target . '" href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>' . $this->escapeHtml(
                        $child->getName()
                    ) . '</span></a>';
                $html .= preg_replace('/class="/', 'class="parent ' . $noParentClass . $attributeClass . $megaMenu , $menuItem, 1);

                $first = true;
                $level = $childLevel + 1;

                foreach ($attributes as $attributeCode)
                {
                    $navNumber = 0;

                    if ($first && count($attributes) != 1)
                    {
                        $first = false;
                        $html .= '<ul class="attribute submenu level' . $level .  ' ' . $hasPromo .'">';
                    }

                    $attribute = $this->eavConfig->getAttribute('catalog_product', $attributeCode);
                    $options = $this->getExistingOptions($attribute);

                    if (count($attributes) != 1)
                    {
                        $html .= '<li class="fary-'. $attributeCode .'"><a href="" ><span>' . $this->escapeHtml(
                                $attribute->getData('frontend_label')
                            ) . '</span></a>';
                    }

                    if ($attributeCode == 'size_name')
                    {
                        $sizes = ['Small' => [], 'Medium' => [], 'Large' => [], 'Extra Large' => []];

                        foreach ($options as $option)
                        {
                            $option = trim($this->escapeHtml($option));

                            if(!empty($option))
                            {
                                $size = strtolower($option);
                                $size = explode('x', $size);

                                $size = intval($size[0]);
                                if ($size >= 1 && $size <= 3)
                                {
                                    if(!in_array($option, $sizes['Small']))
                                        $sizes['Small'][] = $option;
                                }
                                elseif ($size >= 4 && $size <= 7)
                                {
                                    if(!in_array($option, $sizes['Medium']))
                                        $sizes['Medium'][] = $option;
                                }
                                elseif ($size >= 8 && $size <= 9)
                                {
                                    if(!in_array($option, $sizes['Large']))
                                        $sizes['Large'][] = $option;
                                }
                                elseif ($size >= 10)
                                {
                                    if(!in_array($option, $sizes['Extra Large']))
                                        $sizes['Extra Large'][] = $option;
                                }
                            }
                        }

                        foreach ($sizes as $sizeCategory => $options)
                        {
                            $options = $this->sortSizes($options);

                            if ($navNumber <= 0)
                            {
                                $html .= '<ul class="submenu level' . ($level + 1) . '">';
                            }

                            $navNumber++;

                            $html .= '<li class="options level' . ($level + 1) . ' nav-' . ($level + 1) . '-' . $navNumber . '"><a href="#"><span>' . $sizeCategory . '</span></a>';

                            $subNavNumber = 0;
                            foreach ($options as $option)
                            {
                                $option = trim($this->escapeHtml($option));

                                if ($subNavNumber <= 0)
                                {
                                    $html .= '<ul class="submenu level' . ($level + 2) . '">';
                                }

                                $subNavNumber++;

                                if (!empty($option))
                                {
                                    $html .= '<li class="options level' . ($level + 2) . ' nav-' . ($level + 2) . '-' . $subNavNumber . '"><a href="' . $child->getUrl() . '?' . $attributeCode . '=' . $option . '"><span>' . $option . '</span></a></li>';
                                }

                                if ($subNavNumber == count($options))
                                {
                                    $html .= '</ul>';
                                }
                            }

                            if($navNumber == count($sizes))
                            {
                                $html .= '</li></ul>';
                            }
                        }

                    }
                    else
                    {
                        foreach ($options as $option)
                        {
                            $option = trim($this->escapeHtml($option));

                            if ($navNumber <= 0)
                            {
                                $html .= '<ul class="submenu level' . ($level + 1) .  ' ' . $hasPromo .'">';
                            }

                            $navNumber++;

                            if (!empty($option))
                            {
                                $html .= '<li class="options level' . ($level + 1) . ' nav-' . ($level + 1) . '-' . $navNumber . '"><a href="' . $child->getUrl() . '?' . $attributeCode . '=' . $option . '"><span>' . $option . '</span></a></li>';
                            }

                            if ($navNumber == count($options))
                            {
                                if(count($attributes) == 1)
                                {
                                    $html .= $promoBlock;
                                }
                                $html .= '</ul>';
                            }
                        }
                    }
                }

                if(count($attributes) != 1)
                {
                    $html .= '</li>';
                    $html .= $promoBlock . '</ul>';
                }

                $html .= '</li>';
            }

            else
            {
                if($child->getData('navigation_type') == 'link')
                {
                    $url = $child->getData('static_link');
                    $url = str_replace(['{base_url}/', '{base_url}'], $this->getBaseUrl(), $url);
                }

                elseif($child->getData('navigation_type') == 'cms_page')
                {
                    $url = $this->pageHelper->getPageUrl($child->getData('cms_page'));
                }

                else
                {
                    $url = $child->getUrl();
                }

                $menuItem = '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>' . '<a target="' . $target . '" href="' . $url . '" ' . $outermostClassCode . '><span>' . $this->escapeHtml($child->getName()) . '</span></a>';
                $html .= preg_replace('/class="/', 'class="parent ' . $megaMenu , $menuItem, 1);

                $html .= $this->_addSubMenu(
                        $child,
                        $childLevel,
                        $childrenWrapClass,
                        $limit
                    ) . '</li>';
                $itemPosition++;
                $counter++;
            }
        }

        if (count($colBrakes) && $limit)
        {
            $html = '<li class="column"><ul>' . $html . '</ul></li>';
        }

        return $html;
    }

    /**
     * Add sub menu HTML code for current menu item
     *
     * @param \Magento\Framework\Data\Tree\Node $child
     * @param string $childLevel
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string HTML code
     */
    protected function _addSubMenu($child, $childLevel, $childrenWrapClass, $limit)
    {
        $html = '';
        if (!$child->hasChildren()) {
            return $html;
        }

        $isMegaMenu = $child->getData('is_mega_menu');

        $promoBlock = $this->getWysiwygFilterContent($child->getData('promo_block'));

        $hasPromo = '';
        if($child->hasChildren() && $isMegaMenu && !empty($promoBlock))
            $hasPromo = ' haspromo';

        $promoBlock = ($child->hasChildren() && $isMegaMenu) ? '<li class="promo">' . $promoBlock . '</li>' : '';

        $colStops = [];
        if ($childLevel == 0 && $limit) {
            $colStops = $this->_columnBrake($child->getChildren(), $limit);
        }

        $html .= '<ul class="level' . $childLevel . $hasPromo . ' submenu">';
        $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
        $html .= $promoBlock . '</ul>';

        return $html;
    }

    /**
     * @param string $value
     * @return string
     */
    public function getWysiwygFilterContent($value='')
    {
        $html = $this->filterProvider->getPageFilter()->filter($value);
        return $html;
    }


    /**
     * @param $attribute
     * @return array
     */
    function getExistingOptions( $attribute )
    {
        $options = $attribute->getSource()->getAllOptions();
        $optionsExists = array();

        foreach ($options as $option) {
            $optionsExists[] = $option['label'];
        }

        return $optionsExists;
    }

    /**
     * @param $options
     * @return array
     */
    public function sortSizes($options)
    {
        $spaces = [];

        foreach ($options as $key => $option)
        {
            $option = strtolower($option);
            $size = explode('x', $option);

            $space = 0;
            if (count($size) > 1)
            {
                $space = $size[0] * $size[1];
            }
            elseif (count($size) == 1)
            {
                $space = $size[0] * $size[0];
            }

            $spaces[$key] = $space;
        }

        asort($spaces);

        $sortedSizes = [];
        foreach ($spaces as $key => $space)
        {
            $sortedSizes[$key] = $options[$key];
        }

        return $sortedSizes;
    }
}