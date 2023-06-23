<?php
/**
 * @author Eboost Team
 * Copyright © 2023 Eboost.  All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace EBoost\DisableCompareProducts\Plugin\Magento\Catalog\Block\Product;

use EBoost\DisableCompareProducts\Observer\LayoutLoadBefore;
use Magento\Framework\App\Config\ScopeConfigInterface;

class AbstractProduct
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * AbstractProduct constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Return 'null' for product compare url if product comparison is disabled.
     *
     * This deals with a number of the templates that rely on this being set to actually show the compare links.
     *
     * @param \Magento\Catalog\Block\Product\AbstractProduct $subject
     * @param string $result
     * @return string|null
     */
    public function afterGetAddToCompareUrl(
        \Magento\Catalog\Block\Product\AbstractProduct $subject,
        $result
    ) {
        $disableCompare = $this->scopeConfig->getValue(LayoutLoadBefore::DISABLE_COMPARE_CONFIG_PATH);

        if ($disableCompare) {
            $result = null;
        }

        return $result;
    }
}
