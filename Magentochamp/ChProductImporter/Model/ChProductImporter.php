<?php
namespace Magentochamp\ChProductImporter\Model;
use Magento\Framework\Model\AbstractModel;

// que implemente de una interfaz con los metodos que tienen que ir
class ChProductImporter extends AbstractModel{

    /**
     * Define resource model
     */
	protected function _construct()
    {
        $this->_init('Magentochamp\ChProductImporter\Model\ResourceModel\ChProductImporter');
    }
}