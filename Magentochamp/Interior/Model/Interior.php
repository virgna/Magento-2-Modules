<?php
namespace Magentochamp\Interior\Model;
  
use Magento\Framework\Model\AbstractModel;
use Magentochamp\Interior\Api\Data\GridInterface;  
class Interior extends AbstractModel implements GridInterface
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Magentochamp\Interior\Model\ResourceModel\Interior');
    }

    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'magentochamp_interior';
 
    /**
     * @var string
     */
    protected $_cacheTag = 'magentochamp_interior';
 
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'magentochamp_interior';
 
   
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
    public function setCity ($city)
    {
        return $this->setData(self::CITY, $city);
    }
}
