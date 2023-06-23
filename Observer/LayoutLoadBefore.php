<?php
/**
 * @author Eboost Team
 * Copyright © 2023 Eboost.  All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace EBoost\DisableCompareProducts\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class LayoutLoadBefore implements ObserverInterface
{
    const DISABLE_COMPARE_CONFIG_PATH = 'catalog/recently_products/disable_compare';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $disableCompare = $this->scopeConfig->getValue(self::DISABLE_COMPARE_CONFIG_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if($disableCompare){
            $layout = $observer->getData('layout');
            $layout->getUpdate()->addHandle('gl_remove_compare_products');
        }
    }
}