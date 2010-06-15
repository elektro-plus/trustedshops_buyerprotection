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
 * @author    Ngoc Anh Doan <nd@symmetrics.de>
 * @copyright 2010 symmetrics gmbh
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.symmetrics.de/
 */

/* @var $this Symmetrics_Buyerprotect_Model_Setup */

$tsProductsIds = Symmetrics_Buyerprotect_Model_Type_Buyerprotect::getAllTsProductIds();
$tsProductsData = array();
$preTaxValue = 1.19;

foreach ($tsProductsIds as $sku => $clearPrice) {
    $tsProductsData['price'] = $clearPrice * $preTaxValue;
    $tsProductsData['name'] = str_replace('080501', '', $sku);
    $tsProductsData['description'] = $tsProductsData['name'];
    $tsProductsData['short_description'] = $tsProductsData['name'];

    $this->createBuyerprotectProduct($sku, $tsProductsData);
}
