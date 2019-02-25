<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lessotech\Alerts\Block\Product;

/**
 * Product view price and stock alerts
 */
class View extends \Magento\ProductAlert\Block\Product\View
{
    /**
     * Retrieve post action config
     *
     * @return string
     */
    public function getPostAction()
    {die('sdfsdfds');
        return $this->getSignupUrl();
    }
}
