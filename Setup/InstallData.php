<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Fary\SimpleMenu\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        /**
         * Add attributes to the eav/attribute
         */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'navigation_type',
            [
                'type'                  => 'varchar',
                'label'                 => 'Navigation Type',
                'input'                 => 'select',
                'source'                => 'Fary\SimpleMenu\Model\Config\Source\NavigationTypeList',
                'required'              => true,
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'General Information',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => true,
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'is_mega_menu',
            [
                'type'                  => 'int',
                'label'                 => 'Mega Menu',
                'input'                 => 'select',
                'source'                => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required'              => true,
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'General Information',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => true,
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'cms_page',
            [
                'type'                  => 'int',
                'label'                 => 'CMS Page',
                'input'                 => 'select',
                'source'                => 'Fary\SimpleMenu\Model\Config\Source\CMSPageList',
                'required'              => false,
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'General Information',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => true,
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'static_link',
            [
                'type'                  => 'varchar',
                'label'                 => 'Static Link',
                'input'                 => 'text',
                'required'              => false,
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'General Information',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => true,
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'mega_menu_attributes',
            [
                'type'                  => 'text',
                'label'                 => 'Mega Menu Attributes',
                'source'                => 'Fary\SimpleMenu\Model\Config\Source\AttributeList',
                'backend'               => 'Fary\SimpleMenu\Model\Config\Source\Backend\MegaMenuAttributes',
                'input'                 => 'multiselect',
                'required'              => false,
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'General Information',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => true,
            ]
        );

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'blank_target',
            [
                'type'                  => 'int',
                'label'                 => 'Blank Target',
                'input'                 => 'select',
                'source'                => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required'              => true,
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'General Information',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => true,
            ]
        );

        /** @var EavSetup $eavSetup */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'promo_block',
            [
                'type'                  => 'text',
                'label'                 => 'Promo Block',
                'input'                 => 'textarea',
                'required'              => false,
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group'                 => 'General Information',
                'wysiwyg_enabled'       => true,
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => false,
                'is_filterable_in_grid' => true,
            ]
        );
    }
}