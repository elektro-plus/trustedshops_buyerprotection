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
 * @category  Symmetrics
 * @package   Symmetrics_Buyerprotect
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Torsten Walluhn <tw@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
 
/**
 * Buyerprotection Product Type Class
 *
 * @category  Symmetrics
 * @package   Symmetrics_Buyerportect
 * @author    symmetrics gmbh <info@symmetrics.de>
 * @author    Torsten Walluhn <tw@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */
class Symmetrics_Buyerprotect_Model_Type_Buyerprotect extends Mage_Catalog_Model_Product_Type_Abstract
{
    /**
     * Constant to get protuct type
     */
    const TYPE_BUYERPROTECT = 'buyerprotect';

    /**
     * Trusted Shops product ids and clear prices.
     * Note: product ids and prices may change in future! The informations were
     * taken from the implementation handbook (Integrationshandbuch) v3.01.
     *
     * @todo implement for this array a static getter method
     *
     * @var array
     */
    protected static $_tsProductIds = array(
        'TS080501_500_30_EUR' => 0.82,
        'TS080501_1500_30_EUR' => 2.47,
        'TS080501_2500_30_EUR' => 4.12,
        'TS080501_5000_30_EUR' => 8.24,
        'TS080501_10000_30_EUR' => 16.47,
        'TS080501_20000_30_EUR' => 32.94
    );

    /**
     * Checks if correct values are set for stock table 'cataloginventory_stock_item'
     *
     * @param Mage_CatalogInventory_Model_Stock_Item $stockItem Stock item object
     *
     * @return bool
     */
    protected static function _checkStockItem(Mage_CatalogInventory_Model_Stock_Item $stockItem)
    {
        if ($stockItem->getUseConfigMaxSaleQty() != 0
            || $stockItem->getUseConfigMinSaleQty() != 0
            || $stockItem->getUseConfigManageStock() != 0
            || $stockItem->getManageStock()!= 0
            // method getMinSaleQty() is implemented and does not return the DB value
            // as expected
            || $stockItem->getData('min_sale_qty') != 1
            || $stockItem->getMaxSaleQty() != 1
            ) {
            
            return false;
        }

        return true;
    }

    /**
     * Check if Product ist virtual, this always returns true
     *
     * @param Mage_Catalog_Model_Product $product product type instance
     *
     * @return boolean
     */
    public function isVirtual($product = null)
    {
        // return True if this product is virtual and false if this product isn't virtual product
        return true;
    }

    /**
     * Static getter for self::$_tsProductIds
     *
     * @return array
     */
    public static function getAllTsProductIds()
    {
        return self::$_tsProductIds;
    }

    /**
     * Before save the product
     *
     * @param Mage_Catalog_Model_Product $product product to save
     *
     * @return null
     */
    public function beforeSave($product = null)
    {
        parent::beforeSave($product);
        $product->setVisibility(1);
        /** @todo calculate brutto price */
    }

    /**
     * Sets correct values if check fails
     *
     * @param Mage_CatalogInventory_Model_Stock_Item $stockItem Stock item object
     *
     * @see self::_checkStockItem()
     * @return void
     */
    public static function checkStockItem(Mage_CatalogInventory_Model_Stock_Item $stockItem)
    {
        if (!self::_checkStockItem($stockItem)) {
            $stockItem->setUseConfigMaxSaleQty(0);
            $stockItem->setUseConfigMinSaleQty(0);
            $stockItem->setUseConfigManageStock(0);
            $stockItem->setManageStock(0);
            $stockItem->setMinSaleQty(1);
            $stockItem->setMaxSaleQty(1);

            $stockItem->save();
        }

        return;
    }
}
