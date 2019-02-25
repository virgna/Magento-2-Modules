<?php
/**
 * Lessotech
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the lessotech.com license that is
 * available through the world-wide-web at this URL:
 * https://www.lessotech.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Lessotech
 * @package     Lessotech_Testimonials
 * @copyright   Copyright (c) Lessotech (http://www.lessotech.com/)
 * @license     http://www.lessotech.com/LICENSE.txt
 */

namespace Lessotech\Testimonials\Model;
  
use Magento\Framework\Model\AbstractModel;
use Lessotech\Testimonials\Api\Data\GridInterface;

class Testimonials extends AbstractModel implements GridInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Lessotech\Testimonials\Model\ResourceModel\Testimonials');
    }

    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'lessotech_testimonials';
 
    /**
     * @var string
     */
    protected $_cacheTag = 'lessotech_testimonials';
 
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'lessotech_testimonials';
 
   
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
     * Get Firstname.
     *
     * @return varchar
     */
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }
 
    /**
     * Set Firstname.
     */
    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }
 
    /**
     * Get lastname.
     *
     * @return varchar
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }
 
    /**
     * Set lastname.
     */
    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }
 
    /**
     * Get email.
     *
     * @return varchar
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }
 
    /**
     * Set email.
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get city.
     *
     * @return varchar
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }
 
    /**
     * Set CITY.
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }
}
