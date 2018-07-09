<?php
namespace Entrepids\ProductImporter\Model;
use Magento\Framework\Model\AbstractModel;

// que implemente de una interfaz con los metodos que tienen que ir
class ProductImporter extends AbstractModel{

	protected function _construct()
    {
        $this->_init('Entrepids\ProductImporter\Model\ResourceModel\ProductImporter');
    }
}