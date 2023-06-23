<?php
/**
 * @author Eboost Team
 * Copyright © 2023 Eboost.  All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EBoost\DisableCompareProducts\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\ScopeInterface;

class LayoutLoadBefore implements ObserverInterface
{
    public const DISABLE_COMPARE_CONFIG_PATH = 'catalog/recently_products/disable_compare';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * LayoutLoadBefore constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Add handle gl_remove_compare_products
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $disableCompare = $this->scopeConfig->getValue(self::DISABLE_COMPARE_CONFIG_PATH, ScopeInterface::SCOPE_STORE);

        if ($disableCompare) {
            $layout = $observer->getData('layout');
            $layout->getUpdate()->addHandle('gl_remove_compare_products');
        }
    }
}
