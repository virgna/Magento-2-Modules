<?php
/**
 * MageMeister Inc.
 *
 * NOTICE OF LICENSE
 *
 * <!--LICENSETEXT-->
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://magemeister.com for more information.
 *
 * @category    MageMeister
 * @package     MageMeister_EggEaster
 * @copyright   Copyright (c) 2013-2018 MageMeister Inc. (http://magemeister.com)
 * @author      Virang Jethva <virang.jethva@magemeister.com>
 * @info        MageMeister Inc. <hello@magemeister.com>
 */
 
namespace MageMeister\EggEaster\Model;
  
use Magento\Framework\Model\AbstractModel;
use MageMeister\EggEaster\Api\Data\GridInterface;  
class EggEaster extends AbstractModel implements GridInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('MageMeister\EggEaster\Model\ResourceModel\EggEaster');
    }

    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'magemeister_eggeaster';
 
    /**
     * @var string
     */
    protected $_cacheTag = 'magemeister_eggeaster';
 
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'magemeister_eggeaster';
 
   
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }
 
    /**
     * Set EntityId.
     */
    public function setId($entityId)
    {
        return $this->setData(self::ID, $entityId);
    }
 
    /**
     * Get Eggcode.
     *
     * @return varchar
     */
    public function getEggcode()
    {
        return $this->getData(self::EGGCODE);
    }
 
    /**
     * Set Eggcode
     */
    public function setEggcode($eggcode)
    {
        return $this->setData(self::EGGCODE, $eggcode);
    }
 
    /**
     * Get eggname.
     *
     * @return varchar
     */
    public function getEggname()
    {
        return $this->getData(self::EGGNAME);
    }
 
    /**
     * Set Eggname.
     */
    public function setEggname($eggname)
    {
        return $this->setData(self::EGGNAME, $eggname);
    }
}
