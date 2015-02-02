<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Junaidbhura_Jbmarketplace_Block_Productlist extends Mage_Catalog_Block_Product_List
{
    
    public $options;
    public $code;
    
    public function _prepareLayout()
    {
       
       // add Home breadcrumb
          $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs');
          if ($breadcrumbs) {
              $store_label = Mage::getModel('jbmarketplace/jbmarketplacevendors')->load($this->getRequest()->getParam('name'), 'store_url')->getStoreName();
              
              $breadcrumbs->addCrumb('home', array(
                  'label' => $this->__('Home'),
                  'title' => $this->__('Go to Home Page'),
                  'link'  => Mage::getBaseUrl()
              ))->addCrumb('store', array(
                  'label' => 'Shop: '.$store_label,
                  'title' => $store_label,
                  'link'  => ''
              ));
          }

          return parent::_prepareLayout();
    }


   /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            /* @var $layer Mage_Catalog_Model_Layer */
            $layer = $this->getLayer();

            $this->_productCollection = $layer->getProductCollection();
            //get warehouse by vendor
            $warehouse_id = Mage::getModel('jbmarketplace/jbmarketplacevendors')->load($this->getRequest()->getParam('name'), 'store_url')->getWarehouseId();
            //filter collection by warehouse
            if($warehouse_id != Mage::getStoreConfig( 'carriers/dropship/default_warehouse' )) {
              $this->_productCollection->addAttributeToFilter('warehouse', $warehouse_id);
            }
            $this->_productCollection->getSelect();
      
            if ($origCategory) {
              $layer->setCurrentCategory($origCategory);
            }
        } 

        return $this->_productCollection;
    }


}
